<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $products = [];

        foreach (range(1,10) as $index) {
            array_push($products, [
                'name' => ucwords($faker->word),
                'category_id' => rand(4, 12),
                'description' => $faker->text,
                'price' => $faker->randomFloat(2, 2, 500),
                'code' => strtoupper(get_random_code())
            ]);
        }

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
