<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [];

        foreach (range(1,3) as $index) {
            array_push($orders, [
                'cart_id' => $index,
                'bank_status' => 'ok',
                'payment_status' => 0,
                'preorder' => 0,
            ]);
        }

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
