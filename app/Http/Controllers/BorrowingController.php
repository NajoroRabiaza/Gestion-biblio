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

        if ($book->available_copies <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Ce livre n\'est plus disponible.',
            ]);
        }

        if ($user->current_borrowings >= $user->max_borrowings) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez atteint votre limite d\'emprunts (' . $user->max_borrowings . ' maximum).',
            ]);
        }

        if (!$user->can_borrow) {
            return response()->json([
                'success' => false,
                'message' => 'Votre compte ne peut pas effectuer d\'emprunts pour le moment.',
            ]);
        }

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

        Borrowing::create([
            'user_id'     => $user->id,
            'book_id'     => $book->id,
            'borrow_date' => Carbon::today(),
            'due_date'    => Carbon::today()->addDays(30),
            'status'      => 'en_cours',
        ]);

        $book->decrement('available_copies');
        $user->increment('current_borrowings');

        return response()->json([
            'success' => true,
            'message' => '"' . $book->title . '" emprunté avec succès. Retour prévu dans 30 jours.',
        ]);
    }

    // le client annule un emprunt
    public function annuler($borrowingId)
    {
        $user = Auth::user();

        $emprunt = Borrowing::where('id', $borrowingId)
            ->where('user_id', $user->id)
            ->where('status', 'en_cours')
            ->firstOrFail();

        $emprunt->book->increment('available_copies');
        $user->decrement('current_borrowings');
        $emprunt->delete();

        return redirect()->route('borrowings.mes-emprunts')->with('success', 'L\'emprunt a été annulé.');
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

    // admin — liste tous les emprunts en cours
    public function adminEmprunts()
    {
        // je récupère tous les emprunts en cours ou en retard, avec les infos du livre et du client
        $emprunts = Borrowing::with('book', 'user')
            ->whereIn('status', ['en_cours', 'en_retard'])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('admin.emprunts.index', compact('emprunts'));
    }

    // admin — valider le retour d'un livre
    public function validerRetour($borrowingId)
    {
        $emprunt = Borrowing::with('book', 'user')->findOrFail($borrowingId);

        // je mets à jour le statut et la date de retour réelle
        $emprunt->update([
            'status'      => 'retourne',
            'return_date' => Carbon::today(),
        ]);

        // je remet l'exemplaire disponible
        $emprunt->book->increment('available_copies');

        // je décrémente le compteur d'emprunts du client
        $emprunt->user->decrement('current_borrowings');

        return redirect()->route('admin.emprunts')->with('success', 'Le retour a été validé.');
    }
}