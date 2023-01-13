<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => 1,
                'parent_id' => null,
                'name' => 'Rings',
                'description' => null,
                'slug' => 'rings',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'parent_id' => null,
                'name' => 'Wings',
                'description' => null,
                'slug' => 'wings',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'parent_id' => null,
                'name' => 'Earrings',
                'description' => null,
                'slug' => 'earrings',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'parent_id' => 1,
                'name' => 'Silver Rings',
                'description' => null,
                'slug' => 'silver-rings',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 1,
                'name' => '18 karat gold rings',
                'description' => null,
                'slug' => '18-karat-gold-rings',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 1,
                'name' => 'Earrings',
                'description' => null,
                'slug' => 'earrings',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 4,
                'name' => 'subcat Silver Rings',
                'description' => null,
                'slug' => 'subcat-silver-rings',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 2,
                'name' => 'Silver Bracelets',
                'description' => null,
                'slug' => 'silver-bracelets',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 2,
                'name' => 'Gold Bracelets',
                'description' => null,
                'slug' => 'gold-bracelets',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 2,
                'name' => 'Pandora Rose',
                'description' => null,
                'slug' => 'wings-pandora-rose',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 3,
                'name' => 'High Quality Silver',
                'description' => null,
                'slug' => 'high-quality-silver',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'parent_id' => 3,
                'name' => 'Pandora Rose',
                'description' => null,
                'slug' => 'earrings-pandora-rose',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
