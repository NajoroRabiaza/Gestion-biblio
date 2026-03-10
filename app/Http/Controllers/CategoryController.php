<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories,name']);

        Category::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'La catégorie a été ajoutée.');
    }

    // retourne JSON pour AJAX
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->books()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer cette catégorie car elle a des livres associés.',
            ]);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'La catégorie a été supprimée.',
        ]);
    }
}