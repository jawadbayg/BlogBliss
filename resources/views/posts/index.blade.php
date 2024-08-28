@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(Auth::user()->hasRole('User'))
<a id="chatbot-toggle" href="{{ route('posts.create') }}" class="floating-button">
  Get Help from AI
</a>


<!-- Include FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



<div class="container mt-4">
    <div class="row">
        <div class="col-md-9">
            <div class="search-container">
                <form id="search-form" method="GET" action="{{ route('posts.index') }}" style="display: flex; flex-grow: 1;">
                    <input type="text" name="query" class="search-input" placeholder="Search..." value="{{ request('query') }}" id="search-input">
                    <button type="submit" class="search-button">Search</button>
                    
                    @if(request('query'))
                        <button type="button" class="clear-button" onclick="clearSearch()">Clear</button>
                    @endif
                </form>
            </div>

            <script>
                function clearSearch() {
                    const form = document.getElementById('search-form');
                    const input = document.getElementById('search-input');
                    input.value = ''; // Clear the input field
                    form.submit(); // Submit the form
                }
            </script>

<div class="row justify-content-start">
    @foreach ($posts as $post)
        <div class="col-md-12 mb-4">
            @if ($post->status === 'published')
                <a href="{{ route('posts.show', $post->id) }}" class="post-link">
                    <div class="post-card d-flex align-items-start">
                        <div class="post-text-content">
                            <p class="text-muted mb-1 d-flex align-items-center">
                                <!-- User's profile image -->
                                @if ($post->user->profile_pic)
                                    <img src="{{ asset('storage/' . $post->user->profile_pic) }}" alt="User Image" class="user-avatar mr-2">
                                @else
                                    <img src="{{ asset('storage/profile_pics/default-avatar.png') }}" alt="Default Avatar" class="user-avatar mr-2">
                                @endif
                                <strong>{{ $post->user->name }}</strong> - {{ $post->created_at->format('F j, Y') }}

                                <!-- Follow/Unfollow Button -->
                                @auth
                                    @if (Auth::id() !== $post->user->id) 
                                        @if (Auth::user()->isFollowing($post->user))
                                            <form action="{{ route('users.unfollow', $post->user->id) }}" method="POST" style="margin-left: auto;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" id="unfollow-btn">✓ Following</button>
                                            </form>
                                        @else
                                            <form action="{{ route('users.follow', $post->user->id) }}" method="POST" style="margin-left: auto;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm" id="follow-btn">+ Follow</button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth

                            </p>

                            <h3 class="post-title">{{ $post->title }}</h3>
                            <p class="post-text-index">{{ \Illuminate\Support\Str::limit(strip_tags($post->text), 200, '...') }}</p>
                        </div>
                        @if ($post->images)
                            <div class="post-image-container-index">
                                @foreach (explode(',', $post->images) as $image)
                                    <img src="{{ asset('storage/uploads/posts/images/' . $image) }}" alt="Post Image" class="post-image">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endif
        </div>
    @endforeach
</div>


            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $posts->appends(['query' => request('query')])->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-3">
 <!-- Sidebar -->
<div class="col-md-3">
     
<div class="sidebar">
    <h5 id="sidebar-headings">Recommended topics</h5>
    
    @if(request('tag'))
        <a href="{{ route('posts.index') }}" class="sidebar-button clear-filter-button">
    Clear Filter
</a>

    @endif
    
    @foreach ($tags as $tag)
        <a href="{{ route('posts.index', ['tag' => $tag]) }}" 
           class="sidebar-button {{ request('tag') == $tag ? 'active' : '' }}" 
           data-tag="{{ $tag }}">
           {{ ucfirst($tag) }}
        </a>
    @endforeach

    <div class="staff-picks" id="sidebar-headings">
    <h5>Staff Picks</h5>
    @foreach ($topLikedPosts as $post)
        <div class="staff-pick-item">
            <div class="user-info">
                @if ($post->user->profile_pic)
                    <img src="{{ asset('storage/' . $post->user->profile_pic) }}" alt="User Image" id="user-avatar-staffpicks" class="user-avatar">
                @else
                    <img src="{{ asset('storage/profile_pics/default-avatar.png') }}" alt="Default Avatar" id="user-avatar-staffpicks" class="user-avatar">
                @endif
                <p class="user-name">{{ $post->user->name }}</p>
            </div>
            <h6 class="post-title">
                <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
            </h6>
          
        </div>
    @endforeach
</div>

<div class="suggested-users" id="sidebar-headings">
        <h5>Connect with +</h5>
        @foreach ($suggestedUsers as $user)
            <div class="suggested-user-item">
                <div class="user-info">
                    @if ($user->profile_pic)
                        <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="User Image" class="user-avatar">
                    @else
                        <img src="{{ asset('storage/profile_pics/default-avatar.png') }}" alt="Default Avatar" class="user-avatar">
                    @endif
                    <p class="user-name">{{ $user->name }}</p>
                </div>
                <form action="{{ route('users.follow', $user->id) }}" method="POST" class="follow-form">
                    @csrf
                    <button type="submit" class="btn btn-sm" id="follow-btn">+ Follow</button>
                </form>
            </div>
        @endforeach
    </div>
    <a href="{{ route('user.list') }}" class="sidebar-button find-people-button">
    Find People
</a>


    <style>
 .suggested-user-item {
    padding: 10px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    margin-bottom: 10px;
   
}

.suggested-user-item .user-info {
    margin-right: 20px;
    display: flex;
    align-items: center;
    flex-grow: 1; /* Allows the user info section to grow and take available space */
}

.suggested-user-item .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.user-name {
    white-space: nowrap; /* Prevents the text from wrapping */
    overflow: hidden; /* Hides the overflow text */
    text-overflow: ellipsis; /* Displays ellipsis for overflowed text */
    max-width: 120px; /* Adjust as needed to fit your layout */
}

.follow-btn-container {
    margin-left: auto; /* Pushes the button to the right end */
}

#follow-btn {
    color: black;
    border: 1.5px solid black;
    font-weight: 700;
    border-radius: 30px;
    padding: 5px 10px; /* Adjust size of the button */
}

#follow-btn:hover {
    color: white;
    background-color: black;
}
</style>

    
</div>
                
@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle tag button clicks
    document.querySelectorAll('.sidebar-button[data-tag]').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            
            // Remove 'active' class from all buttons
            document.querySelectorAll('.sidebar-button').forEach(btn => btn.classList.remove('active'));
            
            // Add 'active' class to the clicked button
            this.classList.add('active');
            
            // Redirect to the URL of the clicked button
            window.location.href = this.href;
        });
    });
    
    // Handle Clear Filter button click
    document.querySelector('.clear-filter-button').addEventListener('click', function(event) {
        event.preventDefault();
        
        // Remove 'active' class from all buttons
        document.querySelectorAll('.sidebar-button').forEach(btn => btn.classList.remove('active'));
        
        // Redirect to the URL to show all posts
        window.location.href = this.href;
    });
});
</script>
@endpush

    
</div>

</div>

    </div>
</div>


@else
@include('partials.admin-nav')

<div class="row">
    <div class="col-lg-8 text-center mx-auto">
        <h2 style="font-family: 'Barlow Semi Condensed', sans-serif;">Manage Posts</h2>
    </div>
</div>

<div class="container">
    <div class="row mb-3">
        <div class="col-lg-12">
            <a class="btn btn-success mb-2" href="{{ route('posts.create') }}">
                <i class="fa fa-plus"></i> Create New Post
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table id="postsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Post</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    $('#postsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('posts.index') }}",
            type: 'GET',
            data: function (d) {
                d.query = $('#searchQuery').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'username', name: 'username' },
            { data: 'post', name: 'post' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        paging: true,
        pageLength: 5,
        language: {
            paginate: {
                previous: '&laquo;',
                next: '&raquo;'
            }
        }
    });
});


function confirmDelete(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the post.',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: `/posts/${postId}/delete`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Post has been deleted successfully!',
                        icon: 'success',
                        timer: 1000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then(() => {
                        $('#postsTable').DataTable().ajax.reload(); 
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while deleting the post.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
}

function submitAction(postId, action) {
    Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we process your request.',
        didOpen: () => {
            Swal.showLoading();
        }
    });

    let url = action === 'approve' ? `/posts/${postId}/approve` : `/posts/${postId}/reject`;

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: action === 'approve' ? 'Post approved successfully!' : 'Post rejected successfully!',
                icon: 'success',
                timer: 1000, 
                timerProgressBar: true,
                showConfirmButton: false
            }).then(() => {
                $('#postsTable').DataTable().ajax.reload(); 
            });
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while processing your request.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}


</script>


@endif
@endsection

@push('styles')
<style>

    #sidebar-headings{
        color: black;
        text-color:black;
    }
    .container {
        max-width: 800px;
    }

    .feed {
        margin-top: 20px;
    }

    .post {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .post-image {
        border-radius: 8px;
    }

    .post-actions button {
        border-radius: 20px;
        padding: 5px 10px;
    }

    .post-actions .btn {
        margin-right: 10px;
    }

    .post-actions .btn-light {
        color: #606770;
        border-color: #ddd;
    }

    .post-actions .btn-light i {
        margin-right: 5px;
    }

    .text-primary {
        color: #007bff;
    }

    /* Styles for user avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endpush
