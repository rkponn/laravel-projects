<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @see https://laravel.com/docs/10.x/eloquent-factories#factory-relationships
         */
        Post::factory(20)
            ->has(
                User::factory()
                    ->count(1)
                    ->state(function (array $attributes, Post $post) {
                        return ['password' => Hash::make('qwertyqwerty'),];
                    }),
                'user'
            )
            ->create();

        // DB::table('follows')->insert([
        //     'user_id' => 200,
        //     'followeduser' => 100
        // ]);

        // DB::table('follows')->insert([
        //     'user_id' => 300,
        //     'followeduser' => 100
        // ]);

        // DB::table('follows')->insert([
        //     'user_id' => 300,
        //     'followeduser' => 200
        // ]);
    }
}
