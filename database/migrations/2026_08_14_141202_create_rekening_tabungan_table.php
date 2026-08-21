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
        Schema::create('rekening_tabungan', function (Blueprint $table) {
            $table->string('no_rek')->primary();
            $table->foreignId('id_nasabah')->constrained('nasabah', 'id_nasabah')->onDelete('cascade');
            $table->bigInteger('saldo')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_tabungan');
    }
};
