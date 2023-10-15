<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Wedding;
use App\Models\WeddingEvent;

class WeddingEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * wedding_events Seed
         * ------------------
         */

        // DB::table('wedding_events')->truncate();
        // echo "Truncate: wedding_events \n";

        $weddings = Wedding::all();
        $names = ['Akad Nikah', 'Resepsi', 'Unduh Mantu'];
        foreach ($weddings as $wedding) {
            foreach($names as $name){
                WeddingEvent::factory()->create([
                    'wedding_id' => $wedding->id,
                    'name' => $name,
                ]);
            }
        }
        $rows = WeddingEvent::all();
        echo " Insert: wedding_events \n\n";
    }
}
