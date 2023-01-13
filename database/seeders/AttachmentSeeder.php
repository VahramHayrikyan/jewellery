<?php

namespace Database\Seeders;

use App\Models\Attachment;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attachments = [];

        $images = scandir(public_path() . '/storage/attachments/products');

        foreach (range(1, 10) as $index) {
            array_push($attachments, [
                'name' => 'image' . $index . '.jpg',
                'path' => 'storage/attachments/products/' . $images[rand(2, 10)],
                'attachable_type' => 'App\Models\Product',
                'attachable_id' => $index
            ]);
        }
        foreach (range(1, 10) as $index) {
            array_push($attachments, [
                'name' => 'image' . $index . '.jpg',
                'path' => 'storage/attachments/products/' . $images[rand(2, 10)],
                'attachable_type' => 'App\Models\Product',
                'attachable_id' => $index
            ]);
        }
        foreach (range(1, 10) as $index) {
            array_push($attachments, [
                'name' => 'image' . $index . '.jpg',
                'path' => 'storage/attachments/products/' . $images[rand(2, 10)],
                'attachable_type' => 'App\Models\Product',
                'attachable_id' => $index
            ]);
        }
        foreach (range(1, 10) as $index) {
            array_push($attachments, [
                'name' => 'image' . $index . '.jpg',
                'path' => 'storage/attachments/products/' . $images[rand(2, 10)],
                'attachable_type' => 'App\Models\Product',
                'attachable_id' => $index
            ]);
        }
        foreach (range(1, 10) as $index) {
            array_push($attachments, [
                'name' => 'image' . $index . '.jpg',
                'path' => 'storage/attachments/products/' . $images[rand(2, 10)],
                'attachable_type' => 'App\Models\Product',
                'attachable_id' => $index
            ]);
        }

        foreach ($attachments as $attachment) {
            Attachment::create($attachment);
        }
    }
}
