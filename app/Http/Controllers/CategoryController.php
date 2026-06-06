<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request)
    {
        // Yahan hum man kar chal rahe hain ki user ke paas ek cafe hai
        // Cafe ID hum user ke authenticated cafe se lenge
        $cafe = Auth::user()->cafes()->first();

        $cafe->categories()->create([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'Category added successfully!');
    }
}