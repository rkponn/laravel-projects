<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\CategoriesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // call seeders before running factories
        $this->call([
            CategoriesTableSeeder::class,
        
        ]);
        /**
         * @see https://laravel.com/docs/10.x/eloquent-factories#factory-relationships
         */
        Post::factory(20)
            ->has(
                User::factory()
                    ->count(1)
                    ->state(function (array $attributes, Post $post) {
                        return ['password' => Hash::make('qwertyqwerty')];
                    }),
                'user'
            )
            ->has(
                Comment::factory()
                    ->count(5)
                    ->state(function (array $attributes, Post $post) {
                        return ['commentable_id' => $post->id, 'commentable_type' => Post::class];
                    }),
                'comments'
            )
            ->create();

    }
}