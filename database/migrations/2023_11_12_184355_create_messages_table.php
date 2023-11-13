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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('content', 300);
            $table->enum('Enviado por', ['client', 'provider']);
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
        Schema::dropIfExists('messages');
    }
};
