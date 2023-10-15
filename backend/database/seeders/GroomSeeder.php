<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Wedding;
use App\Models\Groom;

class GroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * Grooms Seed
         * ------------------
         */

        // DB::table('grooms')->truncate();
        // echo "Truncate: grooms \n";

        $weddings = Wedding::all();
        foreach ($weddings as $wedding) {
            Groom::factory()->create(['wedding_id' => $wedding->id]);
        }
        $rows = Groom::all();
        echo " Insert: grooms \n\n";
    }
}
