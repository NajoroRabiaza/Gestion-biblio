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

require __DIR__.'/auth.php';