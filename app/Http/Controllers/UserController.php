<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Mail\UserAccepted;
use App\Mail\UserRejected;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request)
     {
         if ($request->ajax()) {
             $data = User::latest()->get();
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('roles', function ($user) {
                     return $user->getRoleNames()->map(function ($role) {
                         return '<label class="badge bg-success">' . $role . '</label>';
                     })->implode(' ');
                 })
                 ->addColumn('status', function ($user) {
                     return $user->isFalse ? '<span class="badge bg-success">Accepted</span>' : '<span class="badge bg-warning">Pending</span>';
                 })
                 ->addColumn('action', function ($user) {
                    $acceptButton = !$user->isFalse ? '<form id="acceptForm' . $user->id . '" method="POST" action="' . route('users.accept', $user->id) . '" style="display:inline">
                        ' . csrf_field() . '
                        <button type="button" class="btn btn-success btn-sm" onclick="submitForm(\'' . $user->id . '\', \'accept\')"><i class="fa-solid fa-check"></i> Accept</button>
                    </form>' : '';
                
                    $rejectButton = !$user->isFalse ? '<form id="rejectForm' . $user->id . '" method="POST" action="' . route('users.reject', $user->id) . '" style="display:inline">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-danger btn-sm" onclick="submitForm(\'' . $user->id . '\', \'reject\')"><i class="fa-solid fa-xmark"></i> Reject</button>
                    </form>' : '';
                
                    $showButton = '<a class="btn btn-primary btn-sm" href="' . route('users.show', $user->id) . '"><i class="fa fa-eye"></i> Show</a>';
                    $editButton = '<a class="btn btn-info btn-sm" href="' . route('users.edit', $user->id) . '"><i class="fa fa-pencil"></i> Edit</a>';
                    $deleteButton = '<form id="deleteForm' . $user->id . '" method="POST" action="' . route('users.destroy', $user->id) . '" style="display:inline">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(\'' . $user->id . '\')"><i class="fa fa-trash"></i> Delete</button>
                    </form>';
                
                    return $acceptButton . $rejectButton . $showButton . $editButton . $deleteButton;
                })
                
                
                 ->rawColumns(['roles', 'status', 'action'])
                 ->make(true);
         }
         
         $data = User::latest()->paginate(1);
         $chartData = User::withCount('posts')->get()->map(function ($user) {
             return [
                 'name' => $user->name,
                 'post_count' => $user->posts_count
             ];
         });
         $pendingCount = User::where('isFalse', 0)->count();
         $pendingPost = Post::where('status', 'pending')->count();
         $postCount = Post::count();
         $userCount = User::count();
         return view('users.index', [
            'pendingPost' => $pendingPost,
            'postCount' =>$postCount,
            'pendingCount' => $pendingCount,
            'userCount' => $userCount,
             'data' => $data,
             'chartData' => $chartData
         ])->with('i', ($request->input('page', 1) - 1) * 5);
     }
     
    
    public function approved(Request $request): View
    {
        $data = User::where('isFalse', true)->latest()->paginate(5);
        
        return view('users.approved', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name','name')->all();

        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
     public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
            
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['isFalse'] = false;  // Set isFalse to false initially
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('users.show',compact('user'));
    }

    
    public function getPendingCount()
    {
        // Get the count of users where 'isFalse' is 0
        $pendingCount = User::where('isFalse', 0)->count();

        // Return the count as a JSON response
        return $pendingCount;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     
    public function update(Request $request, $id)
    {
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|same:confirm-password',
        'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for profile picture
    ]);

    $input = $request->all();

    if ($request->hasFile('profile_pic')) {
        $file = $request->file('profile_pic');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/profile_pics', $filename); // Store file in public/storage/profile_pics

        // Remove previous profile picture if it exists
        $user = User::find($id);
        if ($user->profile_pic && Storage::exists('public/profile_pics/' . $user->profile_pic)) {
            Storage::delete('public/profile_pics/' . $user->profile_pic);
        }

        // Save new profile picture path
        $input['profile_pic'] = $filename;
    } else {
        $input = Arr::except($input, ['profile_pic']); // Remove the profile_pic key if no file is uploaded
    }

    if (!empty($input['password'])) {
        $input['password'] = Hash::make($input['password']);
    } else {
        $input = Arr::except($input, ['password']);
    }

    $user = User::find($id);
    $user->update($input);

    // Handle roles (if applicable)
    DB::table('model_has_roles')->where('model_id', $id)->delete();
    $user->assignRole($request->input('roles'));

    return redirect()->route('users.index')->with('success', 'User updated successfully');
}
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'An error occurred while deleting the user.'], 500);
    }
}



    public function accept($id): RedirectResponse
    {
        $user = User::find($id);
        $user->isFalse = true; // Update to accepted
        $user->save();
    
        // Send acceptance email
        Mail::to($user->email)->send(new UserAccepted($user));
    
        return redirect()->route('users.index')
                         ->with('success', 'User accepted successfully and email sent.');
    }
    
    public function reject($id): RedirectResponse
    {
        $user = User::find($id);
        $user->delete(); // Optionally delete the user
    
        // Send rejection email
        Mail::to($user->email)->send(new UserRejected($user));
    
        return redirect()->route('users.index')
                         ->with('success', 'User rejected successfully and email sent.');
    }







    public function editProfile()

    {
        $followedUsers = auth()->user()->following()->get();
        $followedCount = $followedUsers->count();
        $user = Auth::user(); // Define the $user variable
        $followers = $user->followers()->get(); // Fetch the followers for the authenticated user
        $followersCount = $followers->count();
        
        return view('profile.edit', compact('user', 'followers','followedUsers', 'followedCount','followersCount')); // Pass both user and followers to the view
    }
    
    /**
     * Update the profile of the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $followedUsers = auth()->user()->following()->get();
        $followedCount = $followedUsers->count();
        $user = Auth::user();
        $user->name = $request->input('name');
    
        if ($request->hasFile('profile_pic')) {
            // Delete old profile picture if it exists
            if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
                Storage::disk('public')->delete($user->profile_pic);
            }
    
            // Store new profile picture
            $path = $request->file('profile_pic')->store('profile_pics', 'public');
            $user->profile_pic = $path;
        }
    
        $user->save();
    
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully');
    }


    public function getUserCount()
    {
        $userCount = User::count();
        return $userCount;
    }

    public function pendingRequests(Request $request): View
    {
        // Fetch users with isFalse = false and status = pending
        $data = User::where('isFalse', false)
                    ->where('status', 'pending')
                    ->latest()
                    ->paginate(5);
    
        $pendingUsersCount = User::where('isFalse', false)
                                 ->where('status', 'pending')
                                 ->count();
    
        return view('users.index', compact('data', 'pendingUsersCount'))
               ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    
    public function logTime(Request $request)
    {
        $user = Auth::user();
        $timeSpent = $request->input('timeSpent');
        
        $user->activityLogs()->create([
            'time_spent' => $timeSpent,
            'visited_at' => now(),
        ]);
    }

   
    public function follow(Request $request, User $user)
    {
        $userToFollow = User::findOrFail($user->id);
        $currentUser = auth()->user();
    
        if ($currentUser->isFollowing($userToFollow)) {
            $currentUser->unfollow($userToFollow);
            $message = 'You have unfollowed ' . $userToFollow->name;
        } else {
            $currentUser->follow($userToFollow);
            $message = 'You are now following ' . $userToFollow->name;
        }
    
        return redirect()->back()->with('success', $message);
    }
    
    public function unfollow(Request $request, User $user)
    {
        $userToUnfollow = User::findOrFail($user->id);
        auth()->user()->unfollow($userToUnfollow);
        return redirect()->back()->with('success', 'You have unfollowed ' . $userToUnfollow->name);
    }
  
    public function list()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get(); // Fetch all users who are not admins
    
        return view('users.list', compact('users'));
    }
    
    public function getPendingPosts()
{
    // Get the count of users where 'isFalse' is 0
    $pendingPost = Post::where('status', 'pending')->count();

    // Return the count as a JSON response
    return $pendingPost;
}

}