<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title_fr')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('subtitle_fr')->nullable();
            $table->string('subtitle_ar')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->string('position')->default('home_hero'); // home_hero, home_side, category
            $table->string('button_text_fr')->nullable();
            $table->string('button_text_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
