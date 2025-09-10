<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

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
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tickets routes (umum untuk user login)
    Route::resource('tickets', TicketController::class);

    // Role-specific routes
    Route::middleware('role:agent')->group(function(){
        Route::get('/agent/tickets', [TicketController::class, 'agentIndex'])->name('agent.tickets');
        // Tambahkan route khusus agent lain jika perlu
    });

    Route::middleware('role:admin')->group(function(){
        Route::get('/admin/tickets', [TicketController::class, 'adminIndex'])->name('admin.tickets');
        // Tambahkan route khusus admin unit lain
    });

    Route::middleware(['auth', 'role:superadmin'])->group(function(){
        Route::get('/superadmin/dashboard', [TicketController::class, 'index'])->name('superadmin.dashboard');
         // Tambahkan route khusus superadmin lain
    });


    Route::middleware('role:pimpinan')->group(function(){
        Route::get('/pimpinan/dashboard', [TicketController::class, 'pimpinanIndex'])->name('pimpinan.dashboard');
        // Tambahkan route khusus pimpinan lain
    });
});

require __DIR__.'/auth.php';
