<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Cache::remember('categories.index', 60, fn () => Category::orderBy('name')->paginate(15));
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('create', Category::class);
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        Category::create($data);
        Cache::forget('categories.index');
        return redirect()->route('categories.index')->with('status', 'Category created');
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', "unique:categories,name,{$category->id}"],
            'slug' => ['required', 'string', 'max:255', "unique:categories,slug,{$category->id}"],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $category->update($data);
        Cache::forget('categories.index');
        return redirect()->route('categories.index')->with('status', 'Category updated');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        Cache::forget('categories.index');
        return back()->with('status', 'Category deleted');
    }
}