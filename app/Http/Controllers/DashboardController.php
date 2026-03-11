<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // stats générales
        $totalLivres    = Book::count();
        $totalMembres   = User::where('role', 'client')->count();
        $empruntsActifs = Borrowing::whereIn('status', ['en_cours', 'en_retard'])->count();
        $empruntsRetard = Borrowing::where('status', 'en_retard')->count();

        // top 3 livres les plus empruntés
        $topLivres = Book::withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->take(3)
            ->get();

        // les 5 derniers emprunts créés
        $derniersEmprunts = Borrowing::with('book', 'user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLivres',
            'totalMembres',
            'empruntsActifs',
            'empruntsRetard',
            'topLivres',
            'derniersEmprunts'
        ));
    }
}