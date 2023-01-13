<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(OauthClientSeeder::class);
        $this->call(GroupSeeder::class);//keep this
        $this->call(ProductSeeder::class);
        $this->call(AttachmentSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(CartProductSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(SiteImageSeeder::class);//keep this
    }
}
