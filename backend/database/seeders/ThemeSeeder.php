<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Theme::create([
            'package_id'        => 1,
            'name'              => 'Basic White',
            'slug'              => 'basic-white',
            'img_preview'       => 'themes/theme-bronze.png',
            'description'       => 'Tema ini didominasi oleh warna basic putih yang simpel.',
            'price'             => 150000,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        Theme::create([
            'package_id'        => 2,
            'name'              => 'Lego',
            'slug'              => 'lego',
            'img_preview'       => 'themes/theme-silver.png',
            'description'       => 'Tema ini didasarkan pada lego yang membuat suasana menjadi fun.',
            'price'             => 300000,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        Theme::create([
            'package_id'        => 3,
            'name'              => 'Luxury Flower',
            'slug'              => 'luxury-flower',
            'img_preview'       => 'themes/theme-gold.png',
            'description'       => 'Tema ini memiliki kesan mewah indah dari bunga.',
            'price'             => 550000,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        $rows = Theme::all();
        echo " Insert: themes \n\n";
    }
}
