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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('hash_id')->index();
            $table->integer('user_id', 20)->index();
            $table->integer('category_id', 20)->index();
            $table->string('title', 255);
            $table->string('img_logo', 255)->nullable();
            $table->string('img_path', 255)->nullable();
            $table->string('img_banner', 255)->nullable();
            $table->text('text'); 
            $table->string('days', 255)->nullable(); 
            $table->string('locate', 255)->nullable(); 
            $table->string('link_locate', 255)->nullable(); 
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
