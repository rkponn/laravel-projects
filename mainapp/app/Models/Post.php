<?php

namespace App\Models;

use App\Traits\Commentable;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Commentable;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    public function syncTags(array $tagNames)
    {
        // Get the current list of tag ids for this post
        $currentTagIds = $this->tags()->pluck('tags.id');

        // Find or create the tags
        $tagIds = collect($tagNames)->map(function ($tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);

            return $tag->id;
        });

        // Find tags to add and to remove
        $tagsToAdd = $tagIds->diff($currentTagIds);
        $tagsToRemove = $currentTagIds->diff($tagIds);

        // Add and remove the tags
        $this->tags()->attach($tagsToAdd);
        $this->tags()->detach($tagsToRemove);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toSearchableArray()
    {
        // Don't want to search the whole database, instead search through columns
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
