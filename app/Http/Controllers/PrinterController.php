<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PrinterMaintenanceDue;
use App\Models\User;

class PrinterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $due = $request->boolean('due');
        $query = Printer::query()->orderBy('name');
        if ($request->filled('location')) {
            $query->where('location', $request->string('location'));
        }
        $printers = $query->paginate(15)->withQueryString();
        if ($due) {
            $printers->getCollection()->transform(function (Printer $p) { return $p; });
        }
        return view('printers.index', compact('printers'));
    }

    public function create()
    {
        return view('printers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'model' => ['nullable','string','max:255'],
            'serial_number' => ['nullable','string','max:255'],
            'location' => ['nullable','string','max:255'],
            'last_service_at' => ['nullable','date'],
            'maintenance_interval_months' => ['required','integer','min:1','max:60'],
            'notes' => ['nullable','string'],
            'image' => ['nullable','image','max:5120'],
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('printers', 'public');
            $data['image_path'] = $path;
        }
        $printer = Printer::create($data);
        return redirect()->route('printers.show', $printer)->with('status', 'Printer created');
    }

    public function show(Printer $printer)
    {
        return view('printers.show', compact('printer'));
    }

    public function edit(Printer $printer)
    {
        return view('printers.edit', compact('printer'));
    }

    public function update(Request $request, Printer $printer)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'model' => ['nullable','string','max:255'],
            'serial_number' => ['nullable','string','max:255'],
            'location' => ['nullable','string','max:255'],
            'last_service_at' => ['nullable','date'],
            'maintenance_interval_months' => ['required','integer','min:1','max:60'],
            'notes' => ['nullable','string'],
            'image' => ['nullable','image','max:5120'],
        ]);
        if ($request->hasFile('image')) {
            if ($printer->image_path) {
                Storage::disk('public')->delete($printer->image_path);
            }
            $path = $request->file('image')->store('printers', 'public');
            $data['image_path'] = $path;
        }
        $printer->update($data);
        return redirect()->route('printers.show', $printer)->with('status', 'Printer updated');
    }

    public function destroy(Printer $printer)
    {
        $printer->delete();
        return redirect()->route('printers.index')->with('status', 'Printer deleted');
    }

    // Mark as serviced: set last_service_at to today
    public function markServiced(Printer $printer)
    {
        $printer->last_service_at = now()->toDateString();
        $printer->save();
        return back()->with('status', 'Printer marked as serviced');
    }

    // Notify admins of due printers
    public function notifyDue()
    {
        $duePrinters = Printer::all()->filter(fn(Printer $p) => $p->is_due);
        if ($duePrinters->isEmpty()) {
            return back()->with('status', 'No printers are currently due for maintenance.');
        }
        $admins = User::where('role', 'admin')->get();
        foreach ($duePrinters as $printer) {
            Notification::send($admins, new PrinterMaintenanceDue($printer));
        }
        return back()->with('status', 'Notifications sent to admins for due printers.');
    }

    // Remove uploaded image
    public function destroyImage(Printer $printer)
    {
        if ($printer->image_path) {
            Storage::disk('public')->delete($printer->image_path);
            $printer->image_path = null;
            $printer->save();
        }
        return back()->with('status', 'Printer image removed');
    }

    // Setup & Maintenance documentation
    public function docs()
    {
        return view('printers.docs');
    }
}