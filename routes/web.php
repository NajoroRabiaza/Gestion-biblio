<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// route pour voir les livres - tout le monde connecté peut voir
Route::get('/livres', [App\Http\Controllers\BookController::class, 'index'])->middleware('auth')->name('books.index');

// routes pour ajouter un livre - seulement l'admin
Route::get('/livres/create', [App\Http\Controllers\BookController::class, 'create'])->middleware('auth')->name('books.create');
Route::post('/livres', [App\Http\Controllers\BookController::class, 'store'])->middleware('auth')->name('books.store');

// routes pour modifier et supprimer un livre - seulement l'admin
Route::get('/livres/{id}/edit', [App\Http\Controllers\BookController::class, 'edit'])->middleware('auth')->name('books.edit');
Route::put('/livres/{id}', [App\Http\Controllers\BookController::class, 'update'])->middleware('auth')->name('books.update');
Route::delete('/livres/{id}', [App\Http\Controllers\BookController::class, 'destroy'])->middleware('auth')->name('books.destroy');

// routes pour les emprunts - client
Route::post('/emprunter/{book}', [App\Http\Controllers\BorrowingController::class, 'emprunter'])->middleware('auth')->name('borrowings.emprunter');
Route::get('/mes-emprunts', [App\Http\Controllers\BorrowingController::class, 'mesEmprunts'])->middleware('auth')->name('borrowings.mes-emprunts');

require __DIR__.'/auth.php';