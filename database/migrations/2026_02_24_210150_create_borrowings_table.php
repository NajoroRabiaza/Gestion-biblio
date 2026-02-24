<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // qui fait l'emprunte
            $table->foreignId('book_id')->constrained('books'); // quel livre
            $table->timestamp('borrow_date')->useCurrent(); // date d'emprunt
            $table->date('due_date'); // date limite de retour (exemple:max 30 jours)
            $table->date('return_date')->nullable(); // date vraie de retour, null si pas encore rendu
            $table->enum('status', ['en_cours', 'retourne', 'en_retard'])->default('en_cours');
            $table->integer('days_overdue')->default(0); // jours de retard

            // les deux bibliothecaires qui valident
            $table->unsignedBigInteger('librarian_borrow_id')->nullable();
            $table->unsignedBigInteger('librarian_return_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // relations avec les bibliothécaires
            $table->foreign('librarian_borrow_id')->references('id')->on('users');
            $table->foreign('librarian_return_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrowings');
    }
}
