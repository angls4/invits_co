<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Wedding;
use App\Models\Bride;

class BrideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * Brides Seed
         * ------------------
         */

        // DB::table('brides')->truncate();
        // echo "Truncate: brides \n";

        $weddings = Wedding::all();
        foreach ($weddings as $wedding) {
            Bride::factory()->create(['wedding_id' => $wedding->id]);
        }
        $rows = Bride::all();
        echo " Insert: brides \n\n";
    }
}
