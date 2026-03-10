<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    // afficher la liste des auteurs
    public function index()
    {
        $authors = Author::withCount('books')->orderBy('name')->get();
        return view('admin.authors.index', compact('authors'));
    }

    // afficher le formulaire d'ajout
    public function create()
    {
        return view('admin.authors.create');
    }

    // enregistrer le nouvel auteur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Author::create([
            'name'        => $request->name,
            'biography'   => $request->biography,
            'nationality' => $request->nationality,
            'birth_date'  => $request->birth_date,
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'L\'auteur a été ajouté.');
    }

    // supprimer un auteur
    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        // je vérifie qu'il n'a pas de livres avant de supprimer
        if ($author->books()->count() > 0) {
            return redirect()->route('admin.authors.index')->with('error', 'Impossible de supprimer cet auteur car il a des livres associés.');
        }

        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'L\'auteur a été supprimé.');
    }
}