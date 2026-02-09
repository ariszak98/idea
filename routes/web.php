<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ideas');
//Route::get('/', function () {return view('welcome');});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas.index');
    Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('idea.show');
    Route::post('/logout', [SessionsController::class, 'destroy']);
});

