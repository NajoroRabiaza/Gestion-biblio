<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrowing;
use Carbon\Carbon;

class VerifierRetards extends Command
{
    // nom de la commande : php artisan emprunts:verifier-retards
    protected $signature = 'emprunts:verifier-retards';

    protected $description = 'Vérifie les emprunts en retard et bloque les clients concernés';

    public function handle()
    {
        // je cherche tous les emprunts encore en cours dont la date de retour prévue est dépassée
        $retards = Borrowing::where('status', 'en_cours')
            ->whereDate('due_date', '<', Carbon::today())
            ->get();

        if ($retards->isEmpty()) {
            $this->info('Aucun retard détecté.');
            return;
        }

        $compteur = 0;

        foreach ($retards as $emprunt) {
            // passer le statut de l'emprunt à en_retard
            $emprunt->status = 'en_retard';
            $emprunt->save();

            // bloquer le client : il ne peut plus emprunter tant qu'il n'a pas rendu
            $client = $emprunt->user;
            if ($client) {
                $client->can_borrow = 0;
                $client->save();
            }

            $compteur++;
        }

        $this->info($compteur . ' emprunt(s) passé(s) en retard.');
    }
}