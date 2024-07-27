<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('edittedbooks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ISBN');
            $table->bigInteger('EAN')->nullable();
            $table->integer('ISMN')->nullable(); //dit is voor bladmuziek, zou misschien niet in deze tabel moeten?
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->bigInteger('set_ISBN')->nullable();
            $table->date('publication_date')->nullable();
            $table->date('first_publication_date')->nullable();
            $table->string('author')->nullable();
            $table->enum('product_form', ['Softcover', 'Hardcover', 'Spiraalbinding'])->nullable();
            $table->string('ebook_format')->nullable(); //deze zou goed met enum kunnen als maar een beperkte hoeveelheid formats beschikbaar zijn
            $table->enum('drm_type', ['None', 'Simple', 'Advanced'])->nullable(); // Nog onduidelijke welke opties er zijn
            $table->enum('edition_type', ['First', 'Revised', 'Special'])->nullable(); // Nog onduidelijke welke opties er zijn
            $table->integer('edition')->nullable();
            $table->integer('pages')->nullable();
            $table->integer('file_size_or_duration')->nullable();
            $table->string('dimensions')->nullable();
            $table->integer('weight')->nullable(); //grams
            $table->integer('illustrations')->nullable();
            $table->string('language')->nullable();
            // $table->enum('language', ['Dutch', 'Englisch', 'German']) Deze kan eventueel voor 'language', geeft geen flexibiliteit voor latere toevoeging van een taal
            $table->string('original_language')->nullable();
            $table->string('original_title')->nullable();
            $table->integer('nur_code')->nullable();
            $table->string('nur_language')->nullable(); //eventueel ook met language enum
            $table->integer('avi_code')->nullable();
            $table->string('avi_language')->nullable(); //eventueel ook met language enum
            $table->string('geo_code')->nullable();
            $table->text('flap_text')->nullable();
            $table->text('short_description')->nullable();
            $table->string('series')->nullable();
            $table->string('primary_image')->nullable();
            $table->json('secondary_images')->nullable();
            $table->boolean('available_CB')->nullable();
            $table->boolean('available_CBC')->nullable(); //wat is het verschil tussen CB en CBC?
            $table->date('release_date')->nullable();
            $table->string('translator')->nullable();
            $table->string('illustrator')->nullable();
            $table->string('theme')->nullable(); 
            $table->json('keywords')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->json('related_products')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edittedbooks');
    }
};
