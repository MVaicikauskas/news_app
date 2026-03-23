<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        $imageFiles = glob(storage_path('app/private/*.jpg'));

        foreach (range(1, 20) as $index) {
            sleep(1);
            $title = 'News Post ' . $index . ': ' . fake()->sentence();
            $post = Post::create([
                Post::COL_USER_ID => $users->random()->{User::COL_ID},
                Post::COL_TITLE => $title,
                Post::COL_SLUG => Str::slug($title) . '-' . Str::random(5),
                Post::COL_EXCERPT => fake()->paragraph(),
                Post::COL_CONTENT => fake()->paragraphs(5, true),
            ]);

            // Add a local image if available, else use a placeholder
            if (!empty($imageFiles)) {
                $imagePath = $imageFiles[($index - 1) % count($imageFiles)];
                $post->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection(Post::MEDIA_COLLECTION_IMAGES);
            } else {
                try {
                    $post->addMediaFromUrl('https://picsum.photos/800/600')
                        ->toMediaCollection(Post::MEDIA_COLLECTION_IMAGES);
                } catch (\Exception $e) {
                    // Skip if network error
                }
            }
        }
    }
}
