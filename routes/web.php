<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// route pour voir les livres - tout le monde connecté peut voir
Route::get('/livres', [App\Http\Controllers\BookController::class, 'index'])->middleware('auth')->name('books.index');

// routes pour ajouter un livre - seulement l'admin
Route::get('/livres/create', [App\Http\Controllers\BookController::class, 'create'])->middleware('auth')->name('books.create');
Route::post('/livres', [App\Http\Controllers\BookController::class, 'store'])->middleware('auth')->name('books.store');
require __DIR__.'/auth.php';
