<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// routes livres
Route::get('/livres', [App\Http\Controllers\BookController::class, 'index'])->middleware('auth')->name('books.index');
Route::get('/livres/create', [App\Http\Controllers\BookController::class, 'create'])->middleware('auth')->name('books.create');
Route::post('/livres', [App\Http\Controllers\BookController::class, 'store'])->middleware('auth')->name('books.store');
Route::get('/livres/{id}/edit', [App\Http\Controllers\BookController::class, 'edit'])->middleware('auth')->name('books.edit');
Route::put('/livres/{id}', [App\Http\Controllers\BookController::class, 'update'])->middleware('auth')->name('books.update');
Route::delete('/livres/{id}', [App\Http\Controllers\BookController::class, 'destroy'])->middleware('auth')->name('books.destroy');

// routes emprunts client
Route::post('/emprunter/{book}', [App\Http\Controllers\BorrowingController::class, 'emprunter'])->middleware('auth')->name('borrowings.emprunter');
Route::get('/mes-emprunts', [App\Http\Controllers\BorrowingController::class, 'mesEmprunts'])->middleware('auth')->name('borrowings.mes-emprunts');
Route::delete('/emprunts/{id}/annuler', [App\Http\Controllers\BorrowingController::class, 'annuler'])->middleware('auth')->name('borrowings.annuler');

// routes admin emprunts
Route::get('/admin/emprunts', [App\Http\Controllers\BorrowingController::class, 'adminEmprunts'])->middleware('auth')->name('admin.emprunts');
Route::post('/admin/emprunts/{id}/retour', [App\Http\Controllers\BorrowingController::class, 'validerRetour'])->middleware('auth')->name('admin.emprunts.retour');

// routes admin auteurs
Route::get('/admin/auteurs', [App\Http\Controllers\AuthorController::class, 'index'])->middleware('auth')->name('admin.authors.index');
Route::get('/admin/auteurs/create', [App\Http\Controllers\AuthorController::class, 'create'])->middleware('auth')->name('admin.authors.create');
Route::post('/admin/auteurs', [App\Http\Controllers\AuthorController::class, 'store'])->middleware('auth')->name('admin.authors.store');
Route::delete('/admin/auteurs/{id}', [App\Http\Controllers\AuthorController::class, 'destroy'])->middleware('auth')->name('admin.authors.destroy');

// routes admin catégories
Route::get('/admin/categories', [App\Http\Controllers\CategoryController::class, 'index'])->middleware('auth')->name('admin.categories.index');
Route::get('/admin/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])->middleware('auth')->name('admin.categories.create');
Route::post('/admin/categories', [App\Http\Controllers\CategoryController::class, 'store'])->middleware('auth')->name('admin.categories.store');
Route::delete('/admin/categories/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->middleware('auth')->name('admin.categories.destroy');

require __DIR__.'/auth.php';