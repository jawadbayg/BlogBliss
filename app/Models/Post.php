<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    // Add 'slug' to the fillable attributes
    protected $fillable = [
        'user_id', 'title', 'text', 'images', 'likes', 'comments', 'tags', 'status', 'audience', 'slug'
    ];

    // Add 'slug' to the casts if needed
    protected $casts = [
        'likes' => 'array',
        'comments' => 'array',
        'status' => 'string',
        'images' => 'string',
        'slug' => 'string', // Ensure slug is cast to string if needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toggleLike($userId)
    {
        $likedUsers = $this->likes ? json_decode($this->likes, true) : [];
        if (in_array($userId, $likedUsers)) {
            $likedUsers = array_diff($likedUsers, [$userId]);
        } else {
            $likedUsers[] = $userId;
        }
        $this->likes = json_encode($likedUsers);
        $this->save();
    }

    public function addComment($userId, $commentText)
    {
        $comments = $this->comments ?? []; // Initialize if null
        $comments[] = [
            'user_id' => $userId,
            'text' => $commentText,
            'created_at' => now(),
        ];
        $this->comments = $comments;
        $this->save();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    // Automatically generate a slug when creating a post
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $slug = Str::slug($post->title, '-');
                $post->slug = $slug;

                // Ensure slug is unique
                $count = 1;
                while (self::where('slug', $post->slug)->exists()) {
                    $post->slug = $slug . '-' . $count++;
                }
            }
        });
    }
}
