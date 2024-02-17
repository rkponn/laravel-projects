<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /*
    Filter what the incoming value for avatar will be.
    */
    protected function avatar(): Attribute
    {
        return Attribute::get(function ($value): string {
            return $value ? '/storage/avatars/'.$value : '/fallback-avatar.jpg';
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // to get the latest follow
    public function latestFollow()
    {
        return $this->hasOne(Follow::class, 'user_id')->latest();
    }

    // to search for users
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
        ];
    }

    // Associations
    public function posts()
    {
        // return relationship between user and a post.
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comments()
    {
        // return relationship between user and a comment.
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function followers()
    {
        // following the foreign
        return $this->hasMany(Follow::class, 'followeduser');
    }

    public function following()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }

    public function feedPost()
    {
        // in between (intermediate)
        return $this->hasManyThrough(Post::class, Follow::class, 'user_id', 'user_id', 'id', 'followeduser');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
