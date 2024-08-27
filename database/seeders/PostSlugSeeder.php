<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all posts
        $posts = DB::table('posts')->get();

        foreach ($posts as $post) {
            // Generate slug
            $slug = Str::slug($post->title, '-');

            // Update post with the generated slug
            DB::table('posts')
                ->where('id', $post->id)
                ->update(['slug' => $slug]);
        }
    }
}
