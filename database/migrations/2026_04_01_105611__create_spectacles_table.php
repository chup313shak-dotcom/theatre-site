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
        Schema::create('spectacles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_tatar')->nullable();
            $table->text('description');
            $table->string('director');
            $table->integer('duration'); // в минутах
            $table->string('genre');
            $table->string('age_limit')->default('0+');
            $table->string('poster')->nullable();
            $table->json('gallery')->nullable(); // дополнительные фото
            $table->float('rating')->default(0);
            $table->integer('reviews_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spectacles');
    }
};
