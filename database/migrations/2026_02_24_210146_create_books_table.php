<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn', 20)->unique()->nullable(); // code ISBN du livre
            $table->string('title'); // titre obligatoire
            $table->foreignId('author_id')->constrained('authors'); // clé étrangère vers auteur
            $table->foreignId('category_id')->constrained('categories'); // clé étrangère vers categories
            $table->string('publisher')->nullable(); // maison d'édition
            $table->year('publication_year')->nullable();
            $table->text('description')->nullable();
            $table->string('language', 50)->default('Français');
            $table->integer('pages')->nullable();
            $table->integer('total_copies')->default(1); // nombre total d'exemplaires
            $table->integer('available_copies')->default(1); // combien sont disponibles
            $table->string('shelf_location', 50)->nullable(); // où est le livre dans la bibliothèque
            $table->string('cover_image')->nullable(); // photo du livre
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('books');
    }
}
