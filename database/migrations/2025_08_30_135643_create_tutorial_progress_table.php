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
        Schema::create('tutorial_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutorial_id')->constrained()->cascadeOnDelete();

            // single key that identifies either a user or a guest session
            $table->string('owner_key')->index(); // e.g., "user:5" or "session:abcd123"

            $table->unsignedInteger('seconds_watched')->default(0);
            $table->unsignedTinyInteger('progress_percent')->default(0); // 0..100
            $table->unsignedInteger('duration_seconds')->nullable();      // from client on load
            $table->unsignedInteger('last_second')->default(0);           // last watched second
            $table->timestamps();
            
            $table->unique(['tutorial_id', 'owner_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial_progress');
    }
};
