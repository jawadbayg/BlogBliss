<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;    
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Constructor to apply middleware for permissions.
     */
    public function __construct()
    {
        // $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:post-delete', ['only' => ['destroy']]);
        // $this->middleware('permission:post-review', ['only' => ['approve', 'reject']]); // Admin review permissions
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
            'audience' => 'required|in:public,followers',
        ]);
    
        $input = $request->all();
        $input['user_id'] = auth()->id();
        $input['status'] = 'pending';
    
        // Extract and handle images from the text editor content
        $text = $request->input('text');
    
        $pattern = '/<img[^>]+src="([^">]+)"/i';
        preg_match_all($pattern, $text, $matches);
    
        $uploadedImages = [];
    
        foreach ($matches[1] as $imageUrl) {
            if (strpos($imageUrl, 'storage/uploads/posts/images/') !== false) {
                $filename = basename($imageUrl);
                $uploadedImages[] = $filename;
            }
        }
    
        // Store the filenames as a comma-separated string
        $input['images'] = implode(',', $uploadedImages);
    
        // Convert tags array to a comma-separated string
        $input['tags'] = implode(',', $request->input('tags', []));
    
        // Create the post
        Post::create($input);
    
        return redirect()->route('posts.create')
                         ->with('success', 'Your post is under review and will not be visible until approved by an admin.');
    }
    
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */



   // app/Http/Controllers/PostController.php

   public function index(Request $request)
   {
       if ($request->ajax()) {
           $query = $request->input('query');
           $posts = Post::query()
               ->when($query, function ($queryBuilder, $search) {
                   $queryBuilder->where('title', 'like', "%{$search}%")
                                ->orWhere('text', 'like', "%{$search}%");
               })
               ->with('user')
               ->latest()
               ->get();
   
           return DataTables::of($posts)
               ->addIndexColumn()
               ->addColumn('username', function($post) {
                   return $post->user->name;
               })
               ->addColumn('post', function($post) {
                   $text = implode(' ', array_slice(explode(' ', $post->text), 0, 50));
                   $text .= (str_word_count($post->text) > 50) ? '... <a href="' . route('posts.show', $post->id) . '">Read more</a>' : '';
   
                   return '<strong>Title: ' . $post->title . '</strong><br>' . $text .
                          ($post->image ? '<br><img src="' . asset('images/' . $post->image) . '" style="max-width: 100px;" alt="Post Image">' : '');
               })
               ->addColumn('status', function($post) {
                   if ($post->status === 'pending') return '<span class="badge bg-warning">Pending</span>';
                   if ($post->status === 'published') return '<span class="badge bg-success">Published</span>';
                   if ($post->status === 'rejected') return '<span class="badge bg-danger">Rejected</span>';
               })
               ->addColumn('action', function($post) {
                   $actions = '<a href="' . route('posts.show', $post->id) . '" class="btn btn-secondary btn-sm">View</a>';
   
                   if ($post->status === 'pending') {
                       $actions .= ' <button type="button" class="btn btn-success btn-sm" onclick="submitAction(\'' . $post->id . '\', \'approve\')">Approve</button>';
                       $actions .= ' <button type="button" class="btn btn-danger btn-sm" onclick="submitAction(\'' . $post->id . '\', \'reject\')">Reject</button>';
                   }
   
                   $actions .= ' <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(\'' . $post->id . '\')">' .
                               '<i class="fa-solid fa-trash"></i> Delete</button>';
   
                   return $actions;
               })
               ->rawColumns(['post', 'status', 'action'])
               ->make(true);
       }
       
       $query = $request->input('query');
       $tag = $request->input('tag');
       $userCount = User::count();
       $tags = Post::pluck('tags')->flatMap(fn($tags) => explode(',', $tags))->unique();
   
       $postsQuery = Post::query()
           ->when($query, function ($queryBuilder, $search) {
               $queryBuilder->where('title', 'like', "%{$search}%")
                            ->orWhere('text', 'like', "%{$search}%");
           })
           ->when($tag, function ($queryBuilder, $tag) {
               $queryBuilder->where('tags', 'like', "%{$tag}%");
           })
           ->where(function ($queryBuilder) {
               $queryBuilder->where('status', 'published')
                            ->when(auth()->check(), function ($queryBuilder) {
                                $queryBuilder->where(function ($q) {
                                    $q->where('audience', 'public')
                                      ->orWhere(function ($q) {
                                          $q->where('audience', 'followers')
                                            ->whereIn('user_id', auth()->user()->following->pluck('id'));
                                      });
                                });
                            });
           })
           ->with('user')
           ->latest();
       
          
           $suggestedUsers = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Admin');
        }) ->inRandomOrder()
        ->take(3)
        ->get();
       $postCount = Post::count();
       $posts = $postsQuery->paginate(8);
   
       $topLikedPosts = $this->getTopLikedPosts();
       $pendingCount = User::where('isFalse', 0)->count();
       $pendingPost = Post::where('status', 'pending')->count();
   
       return view('posts.index', compact('posts', 'tags', 'topLikedPosts', 'userCount', 'postCount','suggestedUsers','pendingCount' , 'pendingPost'));
   }
   

     
     

    /**
     * Display a listing of published posts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function userIndex(Request $request): View
    {
        // Get the ID of the currently authenticated user
        $userId = auth()->id();
    
        // Query for posts created by the user with 'published' status
        $posts = Post::where('user_id', $userId)
                     ->where('status', 'published')
                     ->latest()
                     ->paginate(5);
    
        return view('posts.userIndex', compact('posts'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\View\View
     */

     // In your PostController or appropriate controller


     public function showFeatured($id): View
     {
         $post = Post::findOrFail($id);
         
         // Don't include comments in the $post data
         return view('posts.show', compact('post'));
     }
     



     public function show($id, $slug = null): View
     {
         $post = Post::findOrFail($id);
     
         
         if ($slug && $slug !== $post->slug) {
             abort(404); 
         }
     
         $suggestedPosts = Post::where('id', '!=', $id)
             ->inRandomOrder()
             ->take(4)
             ->get();
         $isAuthenticated = Auth::check();
         $post->comments = $post->comments ?? [];
     
         return view('posts.show', compact('post', 'isAuthenticated', 'suggestedPosts'));
     }
     

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\View\View
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ]);
    
        // Check if the authenticated user is the owner of the post
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('posts.index')
                             ->with('error', 'Unauthorized action.');
        }
    
        $input = $request->except('image'); // Exclude image from $input
    
        // If a new image is uploaded, store it and update the image path
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image && Storage::disk('public')->exists('images/' . $post->image)) {
                Storage::disk('public')->delete('images/' . $post->image);
            }
    
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);
    
            $input['image'] = $imageName;
        } else {
            // Keep the existing image if no new image is uploaded
            $input['image'] = $post->image;
        }
    
        // Handle tags
        if ($request->has('tags')) {
            $input['tags'] = implode(',', $request->input('tags', []));
        } else {
            $input['tags'] = $post->tags;
        }
    
        // Update the post with the provided data
        $post->update($input);
    
        // Debug: Log the updated post data
        \Log::info('Post updated: ', $input);
    
        return redirect()->route('posts.index')
                         ->with('success', 'Post updated successfully.');
    }
    
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
    
        // Check if the authenticated user is an admin
        if (Auth::user()->hasRole('Admin')) {
            // Admin can delete any post
            $post->delete();
            return response()->json(['success' => 'Post deleted successfully.']);
        }
    
        // Regular users can only delete their own posts
        if ($post->user_id != Auth::id()) {
            return response()->json(['error' => 'You do not have permission to delete this post.'], 403);
        }
    
        // Delete the post
        $post->delete();
    
        return response()->json(['success' => 'Post deleted successfully.']);
    }
    

    /**
     * Like or unlike a post.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function like($postId)
    {
        $post = Post::findOrFail($postId);
        $userId = auth()->id();
        
        $likes = json_decode($post->likes, true) ?? [];
        
        if (in_array($userId, $likes)) {
            // Unlike
            $likes = array_diff($likes, [$userId]);
        } else {
            // Like
            $likes[] = $userId;
        }
    
        $post->likes = json_encode($likes);
        $post->save();
        
        $likeCount = count($likes);
        $likesHtml = '';
        foreach ($likes as $userId) {
            $user = \App\Models\User::find($userId);
            if ($user) {
                $likesHtml .= '<span class="badge badge-custom-blue">' . htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') . '</span><br>';
            } else {
                // Optionally, you could also remove invalid user IDs from the likes array here.
                $likesHtml .= '<span class="badge badge-danger">Unknown User</span><br>';
            }
        }
    
        return response()->json([
            'liked' => in_array($userId, $likes),
            'likeCount' => $likeCount,
            'likesHtml' => $likesHtml
        ]);
    }
    

    /**
     * Add a comment to a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $userId = auth()->id();
        $commentText = $request->input('text');

        if ($post->comments === null) {
            $post->comments = [];
        }

        $post->addComment($userId, $commentText);

        $user = User::find($userId);

        return response()->json([
            'comment' => [
                'user_id' => $userId,
                'text' => $commentText,
                'created_at' => now()->toDateTimeString(),
            ],
            'user' => [
                'name' => $user->name,
                'profile_pic' => $user->profile_pic
            ],
        ]);
    }
  
    /**
     * Approve a post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'published';
        $post->save();
    

    
        return response()->json(['message' => 'Post approved successfully.']);
    }
    
    public function reject($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'rejected';
        $post->save();
    
    
        return response()->json(['message' => 'Post rejected successfully.']);
    }
    
    
    

    public function getPostCount()
    {
        $postCount = Post::count();
        return response()->json(['postCount' => $postCount]);
    }

    public function getTopLikedPosts()
    {
        $posts = Post::all(); // Retrieve all posts
    
        // Sort posts by the number of likes (assuming likes are stored as a JSON array)
        $posts = $posts->sortByDesc(function($post) {
            $likes = json_decode($post->likes, true) ?? [];
            return count($likes);
        });
    
        // Get the top 3 posts
        $topLikedPosts = $posts->take(3);
    
        return $topLikedPosts;
    }
    


public function uploadImage(Request $request)
{
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $filePath = 'uploads/posts/images/' . $filename;

        // Store the image in the 'public' disk
        $path = $file->storeAs('public/uploads/posts/images', $filename);

        return response()->json(['link' => asset('storage/uploads/posts/images/' . $filename)]);
    }

    return response()->json(['error' => 'Image upload failed'], 400);
}



public function getPendingPosts()
{
    $pendingPost = Post::where('status', 'pending')->count();
    return response()->json(['pendingPost' => $pendingPost]);
}



}
