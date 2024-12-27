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
        Schema::create('libraries', function (Blueprint $table) {
            $table->id("id_library");
            $table->string("name", 200);
            $table->string("address", length: 200);
            $table->timestamps();
        });

        //Se inserta una libreria por defecto hasta que se requiera
        DB::table('libraries')->insert([
            'id_library' => 1,
            'name' => 'Kenedy',
            'address' => 'Calle 11 #10-20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
