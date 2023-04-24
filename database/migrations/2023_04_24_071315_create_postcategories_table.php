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
        Schema::create('postcategories', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('parent_id');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->boolean('masterstatus')->default(false);
            $table->boolean('status')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('parent_id')->references('id')->on('postcategories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postcategories');
    }
};
