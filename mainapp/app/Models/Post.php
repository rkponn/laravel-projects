<?php

namespace App\Models;

use Database\Factories\PostFactory;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Post extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toSearchableArray()
    {
        // Dont want to search the whole database, instead search through columns
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    protected function title(): Attribute
    {
        return Attribute::set(fn (string $value) => strip_tags($value));
    }

    protected function body(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::markdown($value),
            set: fn (string $value) => strip_tags($value),
        );
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
