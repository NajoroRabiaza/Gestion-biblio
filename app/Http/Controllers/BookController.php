<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

class BookController extends Controller
{
    // afficher la liste des livres
    public function index()
    {
        $books = Book::with('author', 'category')->get();
        return view('books.index', compact('books'));
    }

    // afficher le formulaire pour ajouter un livre
    public function create()
    {
        // je récupère les auteurs et catégories pour les mettre dans le formulaire
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }

    // enregistrer le nouveau livre dans la base de données
    public function store(Request $request)
    {
        // je vérifie que les champs importants sont remplis
        $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'category_id' => 'required',
            'total_copies' => 'required',
        ]);

        // je crée le livre
        Book::create([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'total_copies' => $request->total_copies,
            'available_copies' => $request->total_copies, // au début tous les exemplaires sont disponibles
        ]);

        // je redirige vers la liste avec un message
        return redirect()->route('books.index')->with('success', 'Le livre a été ajouté !');
    }
}