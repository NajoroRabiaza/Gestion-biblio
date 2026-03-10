<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->orderBy('name')->get();
        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        Author::create([
            'name'        => $request->name,
            'biography'   => $request->biography,
            'nationality' => $request->nationality,
            'birth_date'  => $request->birth_date,
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'L\'auteur a été ajouté.');
    }

    // retourne JSON pour AJAX
    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        if ($author->books()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer cet auteur car il a des livres associés.',
            ]);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'L\'auteur a été supprimé.',
        ]);
    }
}