<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // une fonction pour afficher la liste de livre
    public function index()
    {
        // je récupère tous les livres avec leur auteur et catégorie
        $books = Book::with('author', 'category')->get();

        return view('books.index', compact('books'));
    }
}