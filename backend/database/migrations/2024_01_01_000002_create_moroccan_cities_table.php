<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moroccan_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name_fr');
            $table->string('name_ar');
            $table->string('region_fr');
            $table->string('region_ar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moroccan_cities');
    }
};
