<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $recordsCount = (int)$this->command->ask('How many records would you like?', 20);
        $users = \App\Models\User::factory($recordsCount)->create();

        // $categories = \App\Models\Post::factory($recordsCount)->create();
        $posts = \App\Models\Post::factory($recordsCount)->make()->each(function ($post) use ($users) {
            $post->author = $users->random()->id;
            $post->save();
        });
        $comments = \App\Models\Comment::factory($recordsCount)->make()->each(function ($comment) use ($posts, $users) {
            $comment->post_id = $posts->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
        $tags = \App\Models\Tag::factory($recordsCount)->create();
        \App\Models\PostTag::factory($recordsCount)->make()->each(function ($postTag) use ($tags, $posts) {
            $postTag->post_id = $posts->random()->id;
            $postTag->tag_id = $tags->random()->id;
            $postTag->save();
        });
        $this->command->info('Successs');
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
