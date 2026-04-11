<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cta_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('ctas', function (Blueprint $table) {
            $table->id();
            $table->string('cta_category_title');
            $table->foreign('cta_category_title')
                  ->references('title')
                  ->on('cta_categories')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->json('items')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ctas');
        Schema::dropIfExists('cta_categories');
    }
};