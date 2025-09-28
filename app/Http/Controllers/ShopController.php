// In your controller (e.g., ShopController.php)
public function index()
{
    $products = Product::paginate(12); // Or Product::all();
    return view('shop', ['products' => $products]);
}
