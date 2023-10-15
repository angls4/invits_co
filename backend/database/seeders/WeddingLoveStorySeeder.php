<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Wedding;
use App\Models\WeddingLoveStory;

class WeddingLoveStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * wedding_love_stories Seed
         * ------------------
         */

        // DB::table('wedding_love_stories')->truncate();
        // echo "Truncate: wedding_love_stories \n";

        $weddings = Wedding::all();
        $years = ['2019', '2020', '2021', '2022', '2023'];
        foreach ($weddings as $wedding) {
            foreach($years as $year){
                WeddingLoveStory::factory()->create([
                    'wedding_id' => $wedding->id,
                    'year' => $year,
                ]);
            }
        }
        $rows = WeddingLoveStory::all();
        echo " Insert: wedding_love_stories \n\n";
    }
}
