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
            $table->string('hash_id')->index();
            $table->string('name', 255);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_num', 15)->nullable(); 
            $table->date('date_of_birth');
            $table->enum('gender', ['L', 'P']); 
            $table->string('img_profil', 255)->nullable();
            $table->string('adress', 255)->nullable(); 
            $table->enum('role', ['adminSP', 'admin', 'user'])->default('user'); 
            $table->rememberToken();
            $table->timestamps();
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
