<?php

// App\Models\Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 'title', 'text', 'images', 'likes', 'comments', 'tags', 'status', 'audience'
    ];

  

    protected $casts = [
        'likes' => 'array', // Assuming likes are stored as a JSON array
        'comments' => 'array', 
        'status' => 'string',
        'images' => 'string',
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
    
}
