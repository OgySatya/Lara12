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
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps(0);
        });
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('jabatan_id')->constrained()->onDelete('cascade');
            $table->timestamps(0);
        });
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('tugas_id')->constrained()->onDelete('cascade');
            $table->timestamps(0);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('jabatans');
        Schema::dropIfExists('tugas');
        Schema::dropIfExists('targets');
    }
};
