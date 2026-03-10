<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // afficher la liste des catégories
    public function index()
    {
        $categories = Category::withCount('books')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // afficher le formulaire d'ajout
    public function create()
    {
        return view('admin.categories.create');
    }

    // enregistrer la nouvelle catégorie
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        Category::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'La catégorie a été ajoutée.');
    }

    // supprimer une catégorie
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // je vérifie qu'elle n'a pas de livres avant de supprimer
        if ($category->books()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Impossible de supprimer cette catégorie car elle a des livres associés.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'La catégorie a été supprimée.');
    }
}