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
        Schema::create('edits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('book_id');
            $table->integer('version');
            $table->string('maintitle')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('collectiontitle')->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('language')->nullable();
            $table->integer('pagecount')->nullable();
            $table->string('keywords')->nullable(); // Datatype can still be changed
            $table->integer('nurcode')->nullable();
            $table->text('shortdescription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edits');
    }
};
