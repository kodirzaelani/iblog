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
        Schema::create('options', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('webname')->nullable();
            $table->string('tagline')->nullable();
            $table->string('description')->nullable();
            $table->string('siteurl')->nullable();
            $table->string('homeurl')->nullable();
            $table->string('language')->nullable();
            $table->string('favicon')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->char('province_code', 2)->nullable();
            $table->char('city_code', 4)->nullable();
            $table->char('district_code', 7)->nullable();
            $table->char('village_code', 7)->nullable();
            $table->text('address')->nullable();
            $table->string('postalcode', 7)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('logo')->nullable();
            $table->integer('post_per_page')->nullable();
            $table->string('timezone')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedln')->nullable();
            $table->string('watshapp')->nullable();
            $table->string('telegram')->nullable();
            $table->text('maps')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('bg_header')->nullable();
            $table->text('bg_statistic')->nullable();
            $table->text('logo_menu')->nullable();
            $table->tinyInteger('fresh_site')->nullable();
            $table->boolean('status_site_update')->default(true);
            $table->timestamps();
            $table->primary('id');

            $table->foreign('province_code')
                ->references('code')
                ->on(config('laravolt.indonesia.table_prefix') . 'provinces')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('city_code')
                ->references('code')
                ->on(config('laravolt.indonesia.table_prefix') . 'cities')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_code')
                ->references('code')
                ->on(config('laravolt.indonesia.table_prefix') . 'districts')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('village_code')
                ->references('code')
                ->on(config('laravolt.indonesia.table_prefix') . 'villages')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
