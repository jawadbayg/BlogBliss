<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Constructor to apply middleware for permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $posts = Post::latest()->paginate(5);

        return view('posts.index', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'text' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle the file upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $image->store('images', 'public');
    }

    // Create the post with the logged-in user's ID
    $post = new Post([
        'user_id' => auth()->id(), // Assuming you're using Laravel's built-in auth system
        'text' => $request->input('text'),
        'image' => $imagePath,
        'likes' => $request->input('likes', 0),
        'comments' => $request->input('comments'),
    ]);

    $post->save();

    return redirect()->route('posts.index')->with('success', 'Post created successfully.');
}

public function update(Request $request, Post $post): RedirectResponse
{
    $request->validate([
        'text' => 'required',
        'image' => 'nullable|image',
        'likes' => 'nullable|integer',
        'comments' => 'nullable|array',
    ]);

    // Ensure the user is authorized to update the post
    if ($post->user_id !== auth()->id()) {
        return redirect()->route('posts.index')
                         ->with('error', 'Unauthorized action.');
    }

    $post->update($request->all());

    return redirect()->route('posts.index')
                    ->with('success', 'Post updated successfully.');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post): View
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success', 'Post deleted successfully.');
    }

    public function like($postId)
    {
        $post = Post::findOrFail($postId);
        $userId = auth()->id(); // Get the currently authenticated user's ID
    
        $likes = json_decode($post->likes, true) ?? [];
    
        if (in_array($userId, $likes)) {
            // User has already liked the post, so remove their like
            $likes = array_diff($likes, [$userId]);
        } else {
            // User has not liked the post yet, so add their like
            $likes[] = $userId;
        }
    
        $post->likes = json_encode($likes);
        $post->save();
    
        return response()->json([
            'status' => 'success',
            'likes' => count($likes)
        ]);
    }
    
    
    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);
    
        $user = auth()->user();
        $comments = json_decode($post->comments, true) ?? [];
        $comment = [
            'text' => $request->input('comment'),
            'user_id' => $user->id
        ];
        
        $comments[] = $comment;
        $post->comments = json_encode($comments);
        $post->save();
    
        return response()->json([
            'status' => 'success',
            'comments' => $comments
        ]);
    }
    
}
