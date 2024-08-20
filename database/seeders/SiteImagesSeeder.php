<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteImagesSeeder extends Seeder
{
    public function run()
    {
        // Array of local image paths to seed
        $images = [
            'site_images/header_image.jpg',
        ];

        foreach ($images as $image) {
            // Check if the image URL already exists
            $existingImage = DB::table('site_images')->where('url', $image)->first();
            
            if ($existingImage) {
                // If the image already exists, update it if needed
                // For example, you can update additional fields if necessary
                DB::table('site_images')->where('url', $image)->update([
                    'updated_at' => now(), // Update timestamp or any other fields if necessary
                ]);
            } else {
                // If the image does not exist, insert it
                DB::table('site_images')->insert([
                    'url' => $image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
