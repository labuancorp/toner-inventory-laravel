<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use App\Models\User;
use App\Models\EmailLog;
use App\Notifications\ReorderAlert;
use App\Notifications\OrderConfirmation;
use App\Notifications\AdminNewOrder;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Events\StockAdjusted as StockAdjustedEvent;

class OrderController extends Controller
{
    public function __construct()
    {
        // Only allow authenticated users to place orders
        $this->middleware('auth')->only('store');
    }

    // Public shop page
    public function index()
    {
        $items = Item::with('category')
            ->orderBy('name')
            ->paginate(16)
            ->withQueryString();

        return view('public.shop', compact('items'));
    }

    // Handle public order submission
    public function store(Request $request)
    {
        // Auth middleware ensures only logged-in users reach here
        $data = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'customer_name' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:255'],
            'shipping_address' => ['nullable', 'string', 'max:255'],
        ]);

        $item = Item::findOrFail($data['item_id']);

        // Ensure sufficient stock
        if ($data['quantity'] > $item->quantity) {
            return back()->withErrors(['quantity' => 'Requested quantity exceeds available stock.'])->withInput();
        }

        // Record stock out movement (authenticated order)
        $movement = StockMovement::create([
            'item_id' => $item->id,
            'user_id' => optional($request->user())->id,
            'type' => 'out',
            'quantity' => (int) $data['quantity'],
            'reason' => 'public_order'.($data['customer_name'] ? ' - '.$data['customer_name'] : ''),
        ]);

        // Adjust item quantity
        $item->decrement('quantity', (int) $data['quantity']);
        $item->refresh();

        // Broadcast stock change
        event(new StockAdjustedEvent($item, $movement));

        // Notify admins if reorder threshold reached
        if ($item->quantity <= $item->reorder_level) {
            $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new ReorderAlert($item));
            }
        }

        // Customer order confirmation (respects preferences)
        try {
            $request->user()->notify(
                new OrderConfirmation(
                    $item,
                    (int) $data['quantity'],
                    $data['customer_name'] ?? null,
                    $data['shipping_address'] ?? null,
                    $data['notes'] ?? null,
                )
            );
            EmailLog::create([
                'user_id' => optional($request->user())->id,
                'to_email' => optional($request->user())->email,
                'subject' => 'Order Confirmation',
                'status' => 'queued',
                'notification_type' => 'order_confirmation',
                'meta' => [
                    'item_id' => $item->id,
                    'quantity' => (int) $data['quantity'],
                ],
            ]);
        } catch (\Throwable $e) {
            EmailLog::create([
                'user_id' => optional($request->user())->id,
                'to_email' => optional($request->user())->email,
                'subject' => 'Order Confirmation',
                'status' => 'failed',
                'notification_type' => 'order_confirmation',
                'meta' => ['error' => $e->getMessage()],
            ]);
        }

        // Admin new order notification with basic rate limiting to prevent flooding
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            $rateKey = 'admin:new-order:minute';
            $maxPerMinute = 60; // allow up to 60 notifications/minute cluster-wide
            $sendNow = !RateLimiter::tooManyAttempts($rateKey, $maxPerMinute);
            RateLimiter::hit($rateKey, 60);
            $notification = new AdminNewOrder(
                $item,
                (int) $data['quantity'],
                $request->user(),
                $data['customer_name'] ?? null,
                $data['shipping_address'] ?? null,
                $data['notes'] ?? null,
            );
            try {
                if ($sendNow) {
                    Notification::send($admins, $notification);
                } else {
                    Notification::send($admins, $notification->delay(now()->addMinute()));
                }
                EmailLog::create([
                    'user_id' => null,
                    'to_email' => null,
                    'subject' => 'New Order Placed',
                    'status' => 'queued',
                    'notification_type' => 'admin_new_order',
                    'meta' => [
                        'item_id' => $item->id,
                        'quantity' => (int) $data['quantity'],
                        'customer_id' => optional($request->user())->id,
                    ],
                ]);
            } catch (\Throwable $e) {
                EmailLog::create([
                    'user_id' => null,
                    'to_email' => null,
                    'subject' => 'New Order Placed',
                    'status' => 'failed',
                    'notification_type' => 'admin_new_order',
                    'meta' => ['error' => $e->getMessage()],
                ]);
            }
        }

        return redirect()->route('shop')->with('status', 'Order placed successfully!');
    }
}