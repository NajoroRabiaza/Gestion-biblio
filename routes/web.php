<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// dashboard admin
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware('admin')->name('dashboard');

// catalogue livres — tout le monde connecté peut voir
Route::get('/livres', [App\Http\Controllers\BookController::class, 'index'])->middleware('auth')->name('books.index');

// gestion livres — admin seulement
Route::get('/livres/create', [App\Http\Controllers\BookController::class, 'create'])->middleware('admin')->name('books.create');
Route::post('/livres', [App\Http\Controllers\BookController::class, 'store'])->middleware('admin')->name('books.store');
Route::get('/livres/{id}/edit', [App\Http\Controllers\BookController::class, 'edit'])->middleware('admin')->name('books.edit');
Route::put('/livres/{id}', [App\Http\Controllers\BookController::class, 'update'])->middleware('admin')->name('books.update');
Route::delete('/livres/{id}', [App\Http\Controllers\BookController::class, 'destroy'])->middleware('admin')->name('books.destroy');

// emprunts client — clients connectés seulement
Route::post('/emprunter/{book}', [App\Http\Controllers\BorrowingController::class, 'emprunter'])->middleware('auth')->name('borrowings.emprunter');
Route::get('/mes-emprunts', [App\Http\Controllers\BorrowingController::class, 'mesEmprunts'])->middleware('auth')->name('borrowings.mes-emprunts');
Route::delete('/emprunts/{id}/annuler', [App\Http\Controllers\BorrowingController::class, 'annuler'])->middleware('auth')->name('borrowings.annuler');

// gestion emprunts — admin seulement
Route::get('/admin/emprunts', [App\Http\Controllers\BorrowingController::class, 'adminEmprunts'])->middleware('admin')->name('admin.emprunts');
Route::post('/admin/emprunts/{id}/retour', [App\Http\Controllers\BorrowingController::class, 'validerRetour'])->middleware('admin')->name('admin.emprunts.retour');

// gestion auteurs — admin seulement
Route::get('/admin/auteurs', [App\Http\Controllers\AuthorController::class, 'index'])->middleware('admin')->name('admin.authors.index');
Route::get('/admin/auteurs/create', [App\Http\Controllers\AuthorController::class, 'create'])->middleware('admin')->name('admin.authors.create');
Route::post('/admin/auteurs', [App\Http\Controllers\AuthorController::class, 'store'])->middleware('admin')->name('admin.authors.store');
Route::delete('/admin/auteurs/{id}', [App\Http\Controllers\AuthorController::class, 'destroy'])->middleware('admin')->name('admin.authors.destroy');

// gestion catégories — admin seulement
Route::get('/admin/categories', [App\Http\Controllers\CategoryController::class, 'index'])->middleware('admin')->name('admin.categories.index');
Route::get('/admin/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->middleware('admin')->name('admin.categories.create');
Route::post('/admin/categories', [App\Http\Controllers\CategoryController::class, 'store'])->middleware('admin')->name('admin.categories.store');
Route::delete('/admin/categories/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->middleware('admin')->name('admin.categories.destroy');

require __DIR__.'/auth.php';