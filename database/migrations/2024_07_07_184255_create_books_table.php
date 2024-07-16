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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->integer('ISBN');
            $table->integer('EAN');
            $table->integer('ISMN')->nullable(); //dit is voor bladmuziek, zou misschien niet in deze tabel moeten?
            $table->string('title');
            $table->string('subtitle');
            $table->integer('set_ISBN');
            $table->date('publication_date');
            $table->date('first_publication_date');
            $table->string('author');
            $table->enum('product_form', ['Softcover', 'Hardcover', 'Spiraalbinding']);
            $table->string('ebook_format')->nullable(); //deze zou goed met enum kunnen als maar een beperkte hoeveelheid formats beschikbaar zijn
            $table->enum('drm_type', ['None', 'Simple', 'Advanced']); // Nog onduidelijke welke opties er zijn
            $table->enum('edition_type', ['First', 'Revised', 'Special']); // Nog onduidelijke welke opties er zijn
            $table->integer('edition');
            $table->integer('pages');
            $table->integer('file_size_or_duration')->nullable();
            $table->string('dimensions')->nullable();
            $table->integer('weight')->nullable(); //grams
            $table->integer('illustrations')->nullable();
            $table->string('language');
            // $table->enum('language', ['Dutch', 'Englisch', 'German']) Deze kan eventueel voor 'language', geeft geen flexibiliteit voor latere toevoeging van een taal
            $table->string('original_language')->nullable();
            $table->string('original_title')->nullable();
            $table->integer('nur_code');
            $table->string('nur_language'); //eventueel ook met language enum
            $table->integer('avi_code')->nullable();
            $table->string('avi_language')->nullable(); //eventueel ook met language enum
            $table->string('geo_code')->nullable();
            $table->text('flap_text')->nullable();
            $table->text('short_description')->nullable();
            $table->string('series')->nullable();
            $table->string('primary_image')->nullable();
            $table->text('secondary_images')->nullable();
            $table->boolean('available_CB');
            $table->boolean('available_CBC'); //wat is het verschil tussen CB en CBC?
            $table->date('release_date');
            $table->string('translator')->nullable();
            $table->string('illustrator')->nullable();
            $table->string('theme')->nullable(); 
            $table->json('keywords')->nullable();
            $table->decimal('price', 8, 2);
            $table->text('related_products')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
