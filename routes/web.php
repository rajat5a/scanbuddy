<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;

/*
|--------------------------------------------------------------------------
| 1. GUEST ROUTES (Bina Login Wale Users Ke Liye)
|--------------------------------------------------------------------------
| Ye pages sirf tab dikhenge jab user logout hoga.
| Agar login user in par aayega, toh seedha Dashboard par chala jayega.
*/
Route::middleware('guest')->group(function () {
    
    // Sign In Page (Laravel ko is route ka naam 'login' chahiye hota hai auth check ke liye)
    Route::get('/signin', function () {
        return view('pages.auth.signin', ['title' => 'Sign In']);
    })->name('login'); 

    // Login Form Submit
    Route::post('/signin', [AuthController::class, 'login'])->name('login.post');

    // --- Sign Up / Registration ---
    // Sign Up Page View
    Route::get('/signup', function () {
        return view('pages.auth.signup', ['title' => 'Sign Up']);
    })->name('signup');

    // Sign Up Form Submit (New Route added for your form action)
    Route::post('/signup', [AuthController::class, 'register'])->name('register.post');

});


/*
|--------------------------------------------------------------------------
| 2. AUTH ROUTES (Sirf Logged-In Users Ke Liye)
|--------------------------------------------------------------------------
| Ye saare pages dashboard ke andar aate hain. 
| Bina login ke koi yahan aayega toh wapas /signin par chala jayega.
*/
Route::middleware('auth')->group(function () {

    // Logout Route (Dashboard se bahar aane ke liye)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // dashboard pages
    Route::get('/', function () {
        return view('pages.dashboard.ecommerce', ['title' => 'E-commerce Dashboard']);
    })->name('dashboard');

    // calender pages
    Route::get('/calendar', function () {
        return view('pages.calender', ['title' => 'Calendar']);
    })->name('calendar');

    // profile pages
    Route::get('/profile', function () {
        return view('pages.profile', ['title' => 'Profile']);
    })->name('profile');

    // form pages
    Route::get('/form-elements', function () {
        return view('pages.form.form-elements', ['title' => 'Form Elements']);
    })->name('form-elements');

    // tables pages
    Route::get('/basic-tables', function () {
        return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
    })->name('basic-tables');

    // blank page
    Route::get('/blank', function () {
        return view('pages.blank', ['title' => 'Blank']);
    })->name('blank');

    // chart pages
    Route::get('/line-chart', function () {
        return view('pages.chart.line-chart', ['title' => 'Line Chart']);
    })->name('line-chart');

    Route::get('/bar-chart', function () {
        return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
    })->name('bar-chart');

    // ui elements pages
    Route::get('/alerts', function () {
        return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
    })->name('alerts');

    Route::get('/avatars', function () {
        return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
    })->name('avatars');

    Route::get('/badge', function () {
        return view('pages.ui-elements.badges', ['title' => 'Badges']);
    })->name('badges');

    Route::get('/buttons', function () {
        return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
    })->name('buttons');

    Route::get('/image', function () {
        return view('pages.ui-elements.images', ['title' => 'Images']);
    })->name('images');

    Route::get('/videos', function () {
        return view('pages.ui-elements.videos', ['title' => 'Videos']);
    })->name('videos');

    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/menu-items/create', [MenuItemController::class, 'create'])->name('menu-items.create');
    Route::post('/menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
    Route::get('/menu-items', [MenuItemController::class, 'index'])->name('menu-items.index');

});


/*
|--------------------------------------------------------------------------
| 3. OPEN ROUTES (Sabke Liye)
|--------------------------------------------------------------------------
*/

// Cafe Menu Route (Publicly visible to customers via QR)
Route::get('/cafe/{slug}', [CafeController::class, 'show'])->name('cafe.menu');

// error pages (Ise open rakha hai taaki error aane par sabko dikhe)
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');