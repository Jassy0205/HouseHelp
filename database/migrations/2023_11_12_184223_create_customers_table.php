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
            $table->string('phone', 10);
            $table->string('email')->unique();
            $table->integer('age');
            $table->enum('gender', ['F', 'M', 'No binario']);
            $table->enum('verification', ['verificado', 'sin verificar']);
            $table->timestamps();

            $table->rememberToken();
            $table->string('password');

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
