<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumText('description');
            $table->decimal('prix', 8, 2); // 8 for precision and 2 for scale
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            //le clé etrangé içi pour les categoies, on utilise constained()
            //pour etablir la relation entre les deux tables.
            $table->string('image_path');
            $table->integer('stock');
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
        Schema::dropIfExists('produits');
    }
}
