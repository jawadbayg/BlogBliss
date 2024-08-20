@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="post-detail">
            <p class="text-muted mb-1 d-flex align-items-center">
                
                @if ($post->user->profile_pic)
                    <img src="{{ asset('storage/' . $post->user->profile_pic) }}" alt="User Image" class="user-avatar mr-2">
                @else
                    <img src="{{ asset('storage/profile_pics/default-avatar.png') }}" alt="Default Avatar" class="user-avatar mr-2">
                @endif
                <strong>{{ $post->user->name }}</strong> - {{ $post->created_at->format('F j, Y') }}
                </p>
                <h1 class="post-title-show">{{ $post->title }}</h1>
                <p><strong>Tags:</strong> {{ $post->tags }}</p>
             

                <div class="post-text-show">
                    <p> {!! $post->text !!}</p>
                </div>
                  <!-- Like/Unlike Button -->
                  @if(Auth::check())
                  <div class="like-container">
    <i id="like-icon" data-post-id="{{ $post->id }}" class="fas fa-thumbs-up {{ in_array(auth()->id(), json_decode($post->likes, true) ?? []) ? 'liked' : '' }}"></i>
    <span id="like-count">{{ count(json_decode($post->likes, true) ?? []) }}</span>
    <div id="likes-tooltip" class="likes-tooltip">
        @forelse (json_decode($post->likes, true) ?? [] as $userId)
            @if($user = App\Models\User::find($userId))
                <span class="badge badge-custom-blue">{{ $user->name }}</span><br>
            @else
                <span class="badge badge-danger">Unknown User</span><br>
            @endif
        @empty
            <span>No likes yet.</span>
        @endforelse
    </div>
</div>


    <!-- Comments Section -->
    <div class="comments-section mt-4">
    <h4>Comments</h4>
    <div id="comments-list">
        @foreach ($post->comments as $comment)
            <div class="comment mb-2">
                <div class="d-flex align-items-center">
                    @php 
                        $commentUser = is_array($comment) ? App\Models\User::find($comment['user_id']) : $comment->user;
                    @endphp
                    @if($commentUser)
                        <img src="{{ $commentUser->profile_pic ? asset('storage/' . $commentUser->profile_pic) : asset('storage/profile_pics/default-avatar.png') }}" alt="User Image" class="user-avatar mr-2">
                        <strong>{{ $commentUser->name }}</strong> 
                    @else
                        <img src="{{ asset('storage/profile_pics/default-avatar.png') }}" alt="Default Avatar" class="user-avatar mr-2">
                        <strong>Unknown User</strong> 
                    @endif
                    <span class="text-muted">{{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}</span>
                </div>
                <p>{{ $comment['text'] }}</p>
            </div>
        @endforeach
    </div>
</div>




                    <form id="comment-form" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="form-group">
                            <textarea name="text" class="form-control" placeholder="Add a comment..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                @else
    <div class="restricted-content">
        <p>You must be <a href="{{ route('login') }}">logged in</a> to like and comment on this post.</p>
    </div>
@endif
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $(document).on('click', '#like-icon', function() {
        var postId = $(this).data('post-id');
        var icon = $(this);
        
        $.ajax({
            url: '/posts/' + postId + '/like',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.liked) {
                    icon.addClass('liked');
                } else {
                    icon.removeClass('liked');
                }
                
                // Update the like count
                $('#like-count').text(response.likeCount);

                // Update the tooltip
                $('#likes-tooltip').html(response.likesHtml);

                // Check if like count is 0
                if (response.likeCount === 0) {
                    icon.removeClass('liked');  // Ensure the icon is black if no likes
                }
            },
            error: function() {
                alert('An error occurred while processing your request.');
            },
            cache: false  // Prevent caching
        });
    });
});



$('#comment-form').submit(function(e) {
    e.preventDefault();
    var form = $(this);

    $.ajax({
        url: '/posts/' + form.find('input[name="post_id"]').val() + '/comment',
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            var profilePicUrl = response.user.profile_pic 
    ? '/storage/' + response.user.profile_pic 
    : '/storage/profile_pics/default-avatar.png';

var commentHtml = '<div class="comment mb-2">' +
    '<div class="d-flex align-items-center">' +
        '<img src="' + profilePicUrl + '" alt="User Image" class="user-avatar mr-2">' +
        '<strong>' + response.user.name + '</strong> <span class="text-muted">' + new Date(response.comment.created_at).toLocaleString() + '</span>' +
    '</div>' +
    '<p>' + response.comment.text + '</p>' +
'</div>';

            $('#comments-list').prepend(commentHtml);

                // Optionally reset the form
            $('#comment-form')[0].reset();
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
            alert('An error occurred while adding your comment.');
        }
    });
});




</script>

<style>
.like-container {
    position: relative;
    display: inline-block;
    font-size: 18px;
}

#like-icon {
    cursor: pointer;
    color: black;
    transition: color 0.3s, transform 0.3s;
}

#like-icon.liked {
    color: #007bff; 
    transform: scale(1.2); 
}

#like-icon.liked:active {
    transform: scale(1); 
}

#like-count {
    margin-left: 5px;

}

.likes-tooltip {
    display: none;
    position: absolute;
    bottom: 100%; /* Position above the icon */
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 10px;
    border-radius: 4px;
    z-index: 10;
    white-space: nowrap;
}

.like-container:hover .likes-tooltip {
    display: block;
}

.comments-section {
    border-top: 1px solid #ddd;
    padding-top: 15px;
}

.comment {
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

textarea.form-control {
    resize: none;
}
</style>

</style>

@endsection
