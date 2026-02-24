<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanction extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_id',
        'user_id',
        'sanction_type',
        'severity',
        'days_late',
        'start_date',
        'end_date',
        'duration_days',
        'status',
        'lifted_date',
        'reason',
        'librarian_id',
        'librarian_lifted_id',
        'notes',
    ];

    // la sanction appartient à un emprunt
    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    // la sanction appartient à un user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
