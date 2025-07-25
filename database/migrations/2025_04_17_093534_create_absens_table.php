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
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('nip');
            $table->integer('shift');
            $table->boolean('pagi')->default(false);
            $table->boolean('malam')->default(false);
            $table->boolean('status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
