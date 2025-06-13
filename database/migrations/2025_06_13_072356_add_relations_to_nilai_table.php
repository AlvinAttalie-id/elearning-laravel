<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_relations_to_nilai_table.php
    public function up()
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->foreignId('tugas_id')->nullable()->constrained('tugas');
            $table->foreignId('jawaban_tugas_id')->nullable()->constrained('jawaban_tugas');
            $table->text('feedback')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            //
        });
    }
};
