<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'isbn',
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

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}