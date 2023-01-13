<?php

namespace Database\Seeders;

use App\Models\SiteImage;
use Illuminate\Database\Seeder;

class SiteImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $siteImages = [];

        foreach (range(1, 6) as $number) {
            array_push($siteImages, [
                'type' => "banner",
                'name' => "banner-$number.jpg",
                'path' => "storage/attachments/banners/banner-$number.jpg",
            ]);
        }

        foreach ($siteImages as $image) {
            SiteImage::create($image);
        }
    }
}
