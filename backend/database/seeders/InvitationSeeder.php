<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Invitation;
use App\Models\Order;

class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * Invitations Seed
         * ------------------
         */

        // DB::table('invitations')->truncate();
        // echo "Truncate: invitations \n";

        $orders = Order::all();
        foreach ($orders as $order) {
            Invitation::factory()->create(['order_id' => $order->id]);
        }
        $rows = Invitation::all();
        echo " Insert: invitations \n\n";
    }
}
