<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    // le client emprunte un livre
    public function emprunter($bookId)
    {
        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        // je vérifie que le livre est disponible
        if ($book->available_copies <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Ce livre n\'est plus disponible.',
            ]);
        }

        // je vérifie que le client peut encore emprunter
        if ($user->current_borrowings >= $user->max_borrowings) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez atteint votre limite d\'emprunts (' . $user->max_borrowings . ' maximum).',
            ]);
        }

        // je vérifie que le client n'est pas bloqué
        if (!$user->can_borrow) {
            return response()->json([
                'success' => false,
                'message' => 'Votre compte ne peut pas effectuer d\'emprunts pour le moment.',
            ]);
        }

        // je vérifie que le client n'a pas déjà emprunté ce même livre sans l'avoir rendu
        $dejaEmprunte = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'en_cours')
            ->exists();

        if ($dejaEmprunte) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà emprunté ce livre.',
            ]);
        }

        // tout est bon, je crée l'emprunt
        Borrowing::create([
            'user_id'     => $user->id,
            'book_id'     => $book->id,
            'borrow_date' => Carbon::today(),
            'due_date'    => Carbon::today()->addDays(30),
            'status'      => 'en_cours',
        ]);

        // je décrémente le nombre d'exemplaires disponibles
        $book->decrement('available_copies');

        // je mets à jour le compteur d'emprunts du client
        $user->increment('current_borrowings');

        return response()->json([
            'success' => true,
            'message' => '"' . $book->title . '" emprunté avec succès. Retour prévu dans 30 jours.',
        ]);
    }

    // le client voit ses emprunts
    public function mesEmprunts()
    {
        $user = Auth::user();

        $emprunts = Borrowing::with('book.author')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('borrowings.mes-emprunts', compact('emprunts'));
    }
}