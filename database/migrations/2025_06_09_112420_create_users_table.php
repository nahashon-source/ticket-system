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
            $table->string('name');
            $table->string('email')->unique(); // Email is unique and indexed
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // Default password field
            $table->enum('role', ['user', 'agent', 'admin'])->default('user'); // Default role is 'user'
            $table->rememberToken(); // For "remember me" functionality
            $table->timestamps(); // Created at and updated at
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
