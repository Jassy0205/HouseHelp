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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('owner', 40);
            $table->integer('phone');
            $table->string('description', 300);
            $table->integer('email')->unique();
            $table->timestamps();

            $table->rememberToken();
            $table->string('password');

            $table->foreignId('company')->nullable();
            $table->foreign('company')->references('id')->on('locations')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
