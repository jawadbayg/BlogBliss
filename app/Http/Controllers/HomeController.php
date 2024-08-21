<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
class HomeController extends Controller
{
    /**
     * Show the welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function welcome(): View
    {
        // Fetch the image URL from the database
        $image = DB::table('site_images')->where('id', 1)->first(); // Adjust ID or query as needed
    
        // Check if image is found
        $imageUrl = $image ? $image->url : '';
    
        // Fetch the featured post
        $featuredPost = Post::find(83);
       
        // Fetch users with the most liked posts
        $topUsers = User::select('users.id', 'users.name', 'users.profile_pic', DB::raw('SUM(JSON_LENGTH(posts.likes)) as total_likes'))
        ->join('posts', 'users.id', '=', 'posts.user_id')
        ->groupBy('users.id', 'users.name', 'users.profile_pic')
        ->orderBy('total_likes', 'DESC')
        ->limit(3)
        ->get();
    
            $topUsers->transform(function ($user) {
                switch ($user->id) {
                    case 1:
                        $user->custom_text = "Inspiration is everywhere, and it is the incredible journey of sharing thoughts and ideas that fuels my passion. BlogBliss has been a beacon of creativity, allowing me to connect with like-minded individuals. The love and support from our community continue to inspire me every day.";
                        break;
                    case 2:
                        $user->custom_text = "The true magic of this blogging site lies in its vibrant community and the endless opportunities it offers for expression. I am deeply inspired by the stories and ideas shared here. It is the collective spirit of our readers and writers that makes every post a unique and cherished experience.";
                        break;
                    case 3:
                        $user->custom_text = "From the first post to the latest, every piece of content on this site has been a labor of love. It’s the encouragement and enthusiasm from our readers that makes all the difference. I am constantly inspired by the innovative ideas and heartfelt responses we receive, making this platform a remarkable place for sharing.";
                        break;
                    default:
                        $user->custom_text = "From the first post to the latest, every piece of content on this site has been a labor of love. It’s the encouragement and enthusiasm from our readers that makes all the difference. I am constantly inspired by the innovative ideas and heartfelt responses we receive, making this platform a remarkable place for sharing.";
                        break;
                }
                return $user;
            });
        
        // Pass data to the view
        return view('welcome', [
           
            'headerImage' => $imageUrl,
            'featuredPost' => $featuredPost,
            'topUsers' => $topUsers,
        ]);
    }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch the image URL from the database
        $image = DB::table('site_images')->where('id', 1)->first();
    
        // Handle case where image is not found
        $imageUrl = $image ? $image->url : '';
    
        // Fetch user and post counts
        $userCount = User::count();
        $postCount = Post::count();
        
    
        // Pass data to the view
        return view('home', [
            'userCount' => $userCount,
            'postCount' => $postCount,
        ]);
    }
    
    
    public function aboutUs()
    {
        return view('about-us');
    }
    
    public function showFeatured(): View
{
    $featuredPost = Post::find(25); // Fetches the post with ID 25
    return view('welcome', compact('featuredPost'));
}

  
}
