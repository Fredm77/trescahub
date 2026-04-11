<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('service_category')->nullable();
            $table->text('description');
            $table->string('budget')->nullable();
            $table->string('timeline')->nullable();
            $table->json('files')->nullable();         // uploaded file paths
            $table->enum('status', ['pending', 'reviewed', 'completed'])
                  ->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};