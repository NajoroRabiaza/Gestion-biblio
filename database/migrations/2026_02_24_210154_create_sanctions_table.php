<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained('borrowings'); // l'emprunt qui a causé la sanction
            $table->foreignId('user_id')->constrained('users'); // le membre sanctionné
            $table->enum('sanction_type', [
                'suspension_emprunt',
                'avertissement',
                'blocage_reservation',
                'reduction_quota',
                'suspension_compte'
            ]);
            $table->enum('severity', ['leger', 'moyen', 'grave'])->default('leger');
            $table->integer('days_late'); // combien de jours de retard
            $table->date('start_date'); // début de la sanction
            $table->date('end_date')->nullable(); // fin, null si permanent
            $table->integer('duration_days')->nullable(); // durée en jours
            $table->enum('status', ['active', 'levee', 'annulee'])->default('active');
            $table->date('lifted_date')->nullable(); // quand la sanction a été enlevée
            $table->text('reason'); // pourquoi la sanction
            // les bibliothécaires
            $table->unsignedBigInteger('librarian_id')->nullable();
            $table->unsignedBigInteger('librarian_lifted_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('librarian_id')->references('id')->on('users');
            $table->foreign('librarian_lifted_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanctions');
    }
}
