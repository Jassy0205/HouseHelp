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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('description', 500);
            $table->integer('price');
            $table->timestamps();

            $table->foreignId('provider')->nullable();
            $table->foreign('provider')->references('id')->on('suppliers')->nullOnDelete()->cascadeOnUpdate();

            $table->foreignId('client')->nullable();
            $table->foreign('client')->references('id')->on('customers')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
