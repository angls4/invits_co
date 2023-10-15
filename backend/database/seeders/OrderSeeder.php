<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * Orders Seed
         * ------------------
         */

        // DB::table('orders')->truncate();
        // echo "Truncate: orders \n";

        Order::factory()->count(50)->create();
        $rows = Order::all();
        echo " Insert: orders \n\n";
    }
}
