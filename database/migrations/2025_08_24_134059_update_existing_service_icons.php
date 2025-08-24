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
        // Update services with combined icons to use the new system
        DB::table('services')->where('icon', 'stethoscope-leaf')->update([
            'icon' => 'stethoscope',
            'secondary_icon' => 'leaf'
        ]);
        
        DB::table('services')->where('icon', 'microscope-leaf')->update([
            'icon' => 'microscope',
            'secondary_icon' => 'leaf'
        ]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the changes if needed
        DB::table('services')->where('icon', 'stethoscope')->where('secondary_icon', 'leaf')->update([
            'icon' => 'stethoscope-leaf',
            'secondary_icon' => null
        ]);
        
        DB::table('services')->where('icon', 'microscope')->where('secondary_icon', 'leaf')->update([
            'icon' => 'microscope-leaf',
            'secondary_icon' => null
        ]);
    }
};
