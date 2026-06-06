<?php

namespace Database\Seeders;

use App\Models\Cafe;
use App\Models\User;
use Illuminate\Database\Seeder;

class CafeDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ek dummy user dhundo ya banao (Auth ke liye)
        $user = User::first() ?? User::factory()->create();

        // 2. Cafe banao
        $cafe = Cafe::create([
            'user_id' => $user->id,
            'name' => 'ScanBuddy Cafe',
            'slug' => 'scanbuddy-cafe',
            'description' => 'Welcome to our digital menu!'
        ]);

        // 3. Category aur MenuItem banao
        $category = $cafe->categories()->create(['name' => 'Hot Beverages']);
        
        $category->menuItems()->create([
            'cafe_id' => $cafe->id,
            'name' => 'Masala Chai',
            'description' => 'Refreshing hot tea',
            'price' => 50.00,
            'is_available' => true
        ]);
    }
}