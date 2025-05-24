<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoCOntroller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// TODO routes
Route::resource('todo', TodoCOntroller::class)->except(['show']);
Route::patch('/todo/{todo}/complete', [TodoCOntroller::class, 'complete'])->name('todo.complete');
Route::patch('/todo/{todo}/incomplete', [TodoCOntroller::class, 'uncomplete'])->name('todo.uncomplete');
Route::delete('/todo', [TodoCOntroller::class, 'destroyCompleted'])->name('todo.deleteallcompleted');

// Admin-only user management
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::resource('category', CategoryController::class);



require __DIR__.'/auth.php';
