<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\PostFactory;

class Post extends Model
{
    // use Searchable;
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toSearchableArray() {
        // Dont want to search the whole database, instead search through columns
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return PostFactory::new();
    }
}
