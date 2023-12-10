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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('identification_card', 10);
            $table->string('name', 20);
            $table->string('lastname', 20);
            $table->string('phone', 10);
            $table->string('email')->unique();
            $table->integer('age');
            $table->enum('type', ['cliente', 'admin']);
            $table->enum('gender', ['F', 'M', 'No binario']);
            $table->timestamps();

            $table->string('password');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
