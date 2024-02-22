<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory;
    use Searchable;

    public function posts()
    {
        // This is the many-to-many relationship between the Category and Post models
        return $this->morphedByMany(Post::class, 'categorizable', 'category_post');
    }
}
