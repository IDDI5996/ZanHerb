<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Product::create([
        'name' => 'ZanHerb Cough Relief',
        'use' => 'Helps relieve dry and productive coughs',
        'ingredients' => 'Ginger, Honey, Eucalyptus, Neem',
        'price' => 8000,
        'pack_size' => '150ml Bottle',
        'tmda_status' => 'Approved',
        'image_path' => 'products/cough-relief.jpg'
    ]);

    Product::create([
        'name' => 'Skin Healing Cream',
        'use' => 'For eczema, rashes, acne and fungal infections',
        'ingredients' => 'Aloe Vera, Coconut Oil, Turmeric, Neem',
        'price' => 12000,
        'pack_size' => '50g Tube',
        'tmda_status' => 'Under Review',
        'image_path' => 'products/skin-heal.jpg'
    ]);
    }
}
