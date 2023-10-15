<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Wedding;
use App\Models\WeddingGallery;

class WeddingGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * wedding_galleries Seed
         * ------------------
         */

        // DB::table('wedding_galleries')->truncate();
        // echo "Truncate: wedding_galleries \n";

        $weddings = Wedding::all();
        foreach ($weddings as $wedding) {
            WeddingGallery::factory()->count(5)->create(['wedding_id' => $wedding->id]);
        }
        $rows = WeddingGallery::all();
        echo " Insert: wedding_galleries \n\n";
    }
}
