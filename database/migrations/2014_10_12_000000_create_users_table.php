<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// migration pour la table users
// j'ai ajouté les colonnes pour le role et les emprunts

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'client'])->default('client');
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->timestamp('registration_date')->useCurrent();
            $table->boolean('is_active')->default(1);
            $table->boolean('can_borrow')->default(1);
            $table->integer('max_borrowings')->default(3);
            $table->integer('current_borrowings')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}