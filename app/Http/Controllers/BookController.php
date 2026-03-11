<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Borrowing;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author', 'category')->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required',
            'author_id'    => 'required',
            'category_id'  => 'required',
            'total_copies' => 'required',
        ]);

        Book::create([
            'title'            => $request->title,
            'isbn'             => $request->isbn,
            'author_id'        => $request->author_id,
            'category_id'      => $request->category_id,
            'total_copies'     => $request->total_copies,
            'available_copies' => $request->total_copies,
        ]);

        return redirect()->route('books.index')->with('success', 'Le livre a été ajouté !');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required',
            'author_id'    => 'required',
            'category_id'  => 'required',
            'total_copies' => 'required',
        ]);

        $book = Book::findOrFail($id);

        $book->update([
            'title'        => $request->title,
            'isbn'         => $request->isbn,
            'author_id'    => $request->author_id,
            'category_id'  => $request->category_id,
            'total_copies' => $request->total_copies,
        ]);

        return redirect()->route('books.index')->with('success', 'Le livre a été modifié !');
    }

    // supprimer un livre — retourne JSON pour AJAX
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // je cherche les emprunts actifs (en cours ou en retard)
        $empruntsActifs = Borrowing::where('book_id', $book->id)
            ->whereIn('status', ['en_cours', 'en_retard'])
            ->with('user')
            ->get();

        // si le livre est en cours d'emprunt, on bloque
        if ($empruntsActifs->isNotEmpty()) {
            $noms = $empruntsActifs->map(function ($e) {
                return $e->user->name;
            })->join(', ');

            return response()->json([
                'success' => false,
                'bloque'  => true,
                'message' => 'Ce livre est actuellement emprunté par : ' . $noms . '. Impossible de le supprimer.',
            ]);
        }

        // aucun emprunt actif — on fait un soft delete
        // les emprunts retournés restent dans la base comme historique
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => '"' . $book->title . '" a été supprimé.',
        ]);
    }
}