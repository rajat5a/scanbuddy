<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use Illuminate\View\View; 

class CafeController extends Controller
{
    // Return type ko JsonResponse se View mein badal dein
    public function show($slug): View 
    {
        $cafe = Cafe::with('categories.menuItems')
                    ->where('slug', $slug)
                    ->firstOrFail();

        return view('pages.cafe.menu', compact('cafe'));
    }
}