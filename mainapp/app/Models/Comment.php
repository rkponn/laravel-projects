<?php

namespace App\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // this model is connected to both User and Post models it has a user_id and a commentable_id/commentable_type
    protected $fillable = ['user_id', 'commentable_id', 'commentable_type', 'body'];

    public function user()
    {
        // This is the one-to-many relationship between the Comment and User models.
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commentable()
    {
        // This is the polymorphic relationship between the Comment and Post models.
        return $this->morphTo();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return CommentFactory::new();
    }
}
