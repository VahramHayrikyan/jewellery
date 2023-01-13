<?php

namespace Database\Seeders;

use App\Models\CartProduct;
use Illuminate\Database\Seeder;

class CartProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        foreach (range(1,40) as $index) {
            array_push($data, [
                'cart_id' => rand(1, 3),
                'product_id' => rand(1, 10),
                'quantity' => rand(1, 5),
                'unit_price' => rand(1, 10),
            ]);
        }

        foreach ($data as $datum) {
            CartProduct::create($datum);
        }
    }
}
