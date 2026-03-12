<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MemberController extends Controller
{
    // liste tous les membres (clients uniquement)
    public function index()
    {
        $membres = User::where('role', 'client')
            ->orderBy('name')
            ->get();

        return view('admin.membres.index', compact('membres'));
    }

    // suspendre ou réactiver un compte
    public function toggleActif($id)
    {
        $membre = User::findOrFail($id);

        // on inverse le statut actif
        $membre->is_active = $membre->is_active ? 0 : 1;
        $membre->save();

        $statut = $membre->is_active ? 'réactivé' : 'suspendu';

        return response()->json([
            'ok' => true,
            'is_active' => $membre->is_active,
            'message' => 'Compte ' . $statut . ' avec succès.',
        ]);
    }
}