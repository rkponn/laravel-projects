<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Technology', 'Health', 'Food', 'Fitness', 'Travel', 'Fashion', 'Finance', 'Education', 
            'Business', 'Entertainment', 'Sports', 'Science', 'Lifestyle', 'Gaming', 'Art', 'Music', 
            'Literature', 'Movies', 'Photography', 'Politics', 'Environment', 'History', 'Psychology', 
            'Law', 'Automotive', 'Real Estate', 'DIY', 'Gardening', 'Cooking', 'Baking', 'Parenting', 
            'Animals', 'Pets', 'Beauty', 'Wellness', 'Astrology', 'Spirituality', 'Philosophy', 'Cultural', 
            'Travel Guides', 'Outdoor Adventures', 'Home Decor', 'Crafts', 'Electronics', 'Mobile Technology', 
            'Software Development', 'Web Development', 'Graphic Design', 'Animation', 'Robotics', 'Aerospace'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category, 
                'created_at' => now(), 
                'updated_at' => now()
            ]);
        }
    }
}