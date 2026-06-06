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
        // View mein category dropdown dikhane ke liye categories fetch karein
        $categories = Auth::user()->cafes()->first()->categories;
        return view('pages.menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $cafe = Auth::user()->cafes()->first();

        MenuItem::create([
            'cafe_id' => $cafe->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return back()->with('success', 'Menu Item added successfully!');
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
}