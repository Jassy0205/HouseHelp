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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->enum('verification', ['verificado', 'sin verificar']);

            $table->foreignId('info_personal')->nullable()->unique();
            $table->foreign('info_personal')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();

            $table->foreignId('home')->nullable();
            $table->foreign('home')->references('id')->on('locations')->nullOnDelete()->cascadeOnUpdate();

            $table->foreignId('verified_by')->nullable()->constrained('administrators');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
