<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'days_overdue',
        'librarian_borrow_id',
        'librarian_return_id',
        'notes',
    ];

    // l'emprunt appartient à un user(le client)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // l'emprunt concerne un livre
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // l'emprunt peut avoir une sanction
    public function sanction()
    {
        return $this->hasOne(Sanction::class);
    }
}
