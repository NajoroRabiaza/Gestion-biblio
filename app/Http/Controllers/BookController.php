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
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }

    // enregistrer le nouveau livre dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'category_id' => 'required',
            'total_copies' => 'required',
        ]);

        Book::create([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'total_copies' => $request->total_copies,
            'available_copies' => $request->total_copies,
        ]);

        return redirect()->route('books.index')->with('success', 'Le livre a été ajouté !');
    }

    // afficher le formulaire de modification d'un livre
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    // enregistrer les modifications du livre
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'category_id' => 'required',
            'total_copies' => 'required',
        ]);

        $book = Book::findOrFail($id);

        $book->update([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'total_copies' => $request->total_copies,
        ]);

        return redirect()->route('books.index')->with('success', 'Le livre a été modifié !');
    }

    // supprimer un livre
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Le livre a été supprimé !');
    }
}