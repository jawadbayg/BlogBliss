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
        'text', 'image', 'likes', 'comments'
    ];

    /**
     * The attributes that should be cast to native types.
     *	
     * @var array
     */
    protected $casts = [
        'likes' => 'integer',
        'comments' => 'array', // If storing comments as JSON, cast it to array
    ];
}
