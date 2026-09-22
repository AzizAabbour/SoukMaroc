<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->enum('role', ['customer', 'seller', 'admin'])->default('customer')->after('phone');
            $table->string('avatar')->nullable()->after('role');
            $table->string('city')->nullable()->after('avatar');
            $table->string('region')->nullable()->after('city');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'avatar', 'city', 'region']);
            $table->dropSoftDeletes();
        });
    }
};
