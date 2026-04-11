<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->json('what_included')->nullable();
            $table->json('how_service_works')->nullable();
            $table->json('other_images')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('working_day')->nullable();
            $table->unsignedBigInteger('classification_name')->nullable();
            $table->json('subcategory')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_in_stock')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};