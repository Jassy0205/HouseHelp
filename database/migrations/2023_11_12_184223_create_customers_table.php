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
            $table->string('name', 20);
            $table->string('lastname', 20);
            $table->integer('phone');
            $table->string('email')->unique();
            $table->integer('age');
            $table->string('gender', 10);
            $table->enum('verification', ['verificado', 'sin verificar']);
            $table->timestamps();

            $table->foreignId('home')->nullable();
            $table->foreign('home')->references('id')->on('locations')->nullOnDelete()->cascadeOnUpdate();
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
