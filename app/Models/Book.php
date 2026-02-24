<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // les colonnes a remplir
    protected $fillable = [
        'isbn',
        'title',
        'author_id',
        'category_id',
        'publisher',
        'publication_year',
        'description',
        'language',
        'pages',
        'total_copies',
        'available_copies',
        'shelf_location',
        'cover_image',
        'is_active',
    ];

    // un livre appartient à un auteur
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    // un livre appartient à une categorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // un livre peut avoir plusieurs emprunts
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
