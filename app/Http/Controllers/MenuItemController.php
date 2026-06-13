<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuItemController extends Controller
{
    public function create()
    {
        $cafe = Auth::user()->cafes()->first();
        $categories = $cafe->categories; // Sirf us cafe ki categories
        return view('pages.menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000', 
        ]);

        $cafe = Auth::user()->cafes()->first();

        // Cafe milna zaroori hai, warna error handle karein
        if (!$cafe) {
            return back()->with('error', 'Cafe not found!');
        }

        // Mass assignment use karein
        $cafe->menuItems()->create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
        ]);

        return redirect()->route('menu-items.index')->with('success', 'Menu Item added successfully!');
    }

    public function index()
    {
        $cafe = Auth::user()->cafes()->first();
        // Database se data lekar use JSON mein convert kar rahe hain
        $menuItems = $cafe->menuItems()->with('category')->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'category' => $item->category->name,
                'price' => '₹' . number_format($item->price, 2),
                'status' => $item->is_available ? 'Success' : 'Failed', // Dummy status
                'date' => $item->created_at->format('M d, h:i A'),
                'image' => $item->image ?? '/images/brand/brand-01.svg', // Default image
            ];
        });

        return view('pages.menu-items.index', compact('menuItems'));
    }

    public function edit($id)
    {
        // Sirf wahi item milna chahiye jo CURRENT USER ke cafe ka ho
        $item = MenuItem::whereHas('cafe', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $categories = Category::where('cafe_id', $item->cafe_id)->get();
        return view('pages.menu-items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
        ]);

        $item = \App\Models\MenuItem::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('menu-items.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $menuItem = \App\Models\MenuItem::findOrFail($id);
        $menuItem->delete();
        return redirect()->back()->with('success', 'Item deleted successfully!');
    }
}