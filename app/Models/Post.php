<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'user_id', 'text', 'image', 'likes', 'comments'
    ];

    /**
     * The attributes that should be cast to native types.
     *	
     * @var array
     */
    protected $casts = [
        'likes' => 'integer',
        'comments' => 'array',
    ];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function toggleLike($userId)
{
    $likedUsers = $this->likes ? json_decode($this->likes, true) : [];
    if (in_array($userId, $likedUsers)) {
        // Unlike
        $likedUsers = array_diff($likedUsers, [$userId]);
    } else {
        // Like
        $likedUsers[] = $userId;
    }
    $this->likes = json_encode($likedUsers);
    $this->save();
}

public function addComment($userId, $commentText)
{
    $comments = $this->comments ? json_decode($this->comments, true) : [];
    $comments[] = [
        'user_id' => $userId,
        'text' => $commentText,
        'created_at' => now(),
    ];
    $this->comments = json_encode($comments);
    $this->save();
}

}
