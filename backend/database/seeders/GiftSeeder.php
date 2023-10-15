<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Wedding;
use App\Models\Gift;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * Gifts Seed
         * ------------------
         */

        // DB::table('gifts')->truncate();
        // echo "Truncate: gifts \n";

        $weddings = Wedding::all();
        foreach ($weddings as $wedding) {
            Gift::factory()->count(5)->create(['wedding_id' => $wedding->id]);
        }
        $rows = Gift::all();
        echo " Insert: gifts \n\n";
    }
}
