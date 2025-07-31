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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('Description');
            $table->double('price');
            $table->string('file_path')->default('0');
            $table->foreignId('category_id');
            $table->foreignId('author_id')->default(0);
            $table->string('author_name');
            $table->foreignId('admin_id');
            $table->integer('quantity');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
