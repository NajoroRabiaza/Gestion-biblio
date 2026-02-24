<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ceci c'est la migration pour la table users
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // clé primaire automatique
            $table->string('name');
            $table->string('email')->unique(); // email unique pour se connecter
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'client'])->default('client'); // admin ou client
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->timestamp('registration_date')->useCurrent();
            $table->boolean('is_active')->default(1); // 1 = actif
            $table->boolean('can_borrow')->default(1); // si il peut emprunter ou pas
            $table->integer('max_borrowings')->default(3); // maximum 3 livres
            $table->integer('current_borrowings')->default(0); // combien il a maintenant de ce emprunt
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
