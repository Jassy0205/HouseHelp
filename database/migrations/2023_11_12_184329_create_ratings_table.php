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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('star');
            $table->string('comment', 300);
            $table->timestamps();

            $table->foreignId('provider')->nullable();
            $table->foreign('provider')->references('id')->on('suppliers')->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignId('client')->nullable();
            $table->foreign('client')->references('id')->on('customers')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
