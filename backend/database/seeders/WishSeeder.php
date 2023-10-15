<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Wedding;
use App\Models\Wish;

class WishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * Wishes Seed
         * ------------------
         */

        // DB::table('wishes')->truncate();
        // echo "Truncate: wishes \n";

        $weddings = Wedding::all();
        foreach ($weddings as $wedding) {
            Wish::factory()->count(5)->create(['wedding_id' => $wedding->id]);
        }
        $rows = Wish::all();
        echo " Insert: wishes \n\n";
    }
}
