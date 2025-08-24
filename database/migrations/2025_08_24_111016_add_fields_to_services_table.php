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
        Schema::table('services', function (Blueprint $table) {
            $table->string('category')->default('Clinical & Therapeutic Care');
            $table->string('icon')->nullable();
            $table->text('long_description')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
             $table->dropColumn(['category', 'icon', 'long_description', 'featured', 'sort_order']);
        });
    }
};
