<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->id();                                      // unsignedBigInteger PK
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable(); // unsigned FK
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')
                  ->references('id')
                  ->on('shop_categories')
                  ->nullOnDelete();                            // null child if parent deleted
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_categories');
    }
};