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
        Schema::create('suppliers_applications', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['rechazada', 'aceptada']);
            $table->timestamps();

            $table->foreignId('provider')->nullable();
            $table->foreign('provider')->references('id')->on('suppliers')->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignId('publishing')->nullable();
            $table->foreign('publishing')->references('id')->on('applications')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers_applications');
    }
};
