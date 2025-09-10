<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('tickets', TicketController::class);


    // Role-specific routes (kosong dulu jika belum dibuat)
    Route::middleware('role:Agent')->group(function(){
        // route khusus agent
    });

    Route::middleware('role:Admin Unit')->group(function(){
        // route khusus admin unit
    });

    Route::middleware('role:Superadmin')->group(function(){
        // route khusus superadmin
    });

    Route::middleware('role:Pimpinan')->group(function(){
        // route khusus pimpinan
    });

});

require __DIR__.'/auth.php';
