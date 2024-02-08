<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        return Attribute::set(fn (string $value) => strip_tags($value));
    }

    protected function bodyMarkdown(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Str::markdown($value) : '',
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
