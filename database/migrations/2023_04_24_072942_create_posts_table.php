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
            $table->uuid('id');
            $table->uuid('author_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('headline');
            $table->boolean('selection');
            $table->uuid('postcategory_id');
            $table->text('content');
            $table->text('excerpt');
            $table->string('image')->nullable();
            $table->string('image_watermark')->nullable();
            $table->text('caption_image')->nullable();
            $table->text('video')->nullable();
            $table->text('caption_video')->nullable();
            $table->boolean('status');
            $table->boolean('comment_status');
            $table->boolean('statuspost')->nullable();
            $table->date('published_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');

            $table->foreign('author_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('postcategory_id')->references('id')->on('postcategories')->onDelete('restrict');

            //create post_tag table
            Schema::create('post_tag', function (Blueprint $table) {
                $table->uuid('post_id');
                $table->uuid('tag_id');
                $table->primary(['post_id', 'tag_id']);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('posts');
    }
};
