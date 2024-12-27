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
            $table->id("id_book");
            $table->unsignedBigInteger("id_library");
            $table->string("title", 200);
            $table->string("author", 120);
            $table->date("date_publication");
            $table->string("gender", 100);
            $table->string("category", 100);

            $table->foreign('id_library')->references('id_library')->on('libraries')->default(1);
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
