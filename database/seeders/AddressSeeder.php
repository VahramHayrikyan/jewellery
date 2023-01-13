<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        DB::table('addresses')->insert([
            [
                'type' => 'billing',
                'user_id' => 1,
                'postal_code' => Str::random(5),
                'state' => $faker->state,
                'city' => $faker->city,
                'street' => $faker->streetAddress,
                'apartment' => $faker->numberBetween(1, 120),
            ],
            [
                'type' => 'shipping',
                'user_id' => 1,
                'postal_code' => Str::random(5),
                'state' => $faker->state,
                'city' => $faker->city,
                'street' => $faker->streetAddress,
                'apartment' => $faker->numberBetween(1, 120),
            ],
            [
                'type' => 'shipping',
                'user_id' => 2,
                'postal_code' => Str::random(5),
                'state' => $faker->state,
                'city' => $faker->city,
                'street' => $faker->streetAddress,
                'apartment' => $faker->numberBetween(1, 120),
            ],
            [
                'type' => 'shipping',
                'user_id' => 3,
                'postal_code' => Str::random(5),
                'state' => $faker->state,
                'city' => $faker->city,
                'street' => $faker->streetAddress,
                'apartment' => $faker->numberBetween(1, 120),
            ],
        ]);
    }
}
