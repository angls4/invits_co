<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Order;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            Payment::create([
                "total_price" => $order->theme->price,
                "user_id" => $order->user->id,
                "order_id" => $order->id
            ]);
        }

        echo " Insert: payments \n\n";
    }
}
