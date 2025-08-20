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
        Schema::table('bookings', function (Blueprint $table) {
            // Add status column
            $table->string('status')
                  ->default('pending')
                  ->after('preferred_time')
                  ->index();
            
            // Add product_id foreign key
            $table->foreignId('product_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('products')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropConstrainedForeignId('product_id');
        });
    }
};
