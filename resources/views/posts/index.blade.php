@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(Auth::user()->hasRole('User'))
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <h2 class="me-auto">Posts</h2>
                @can('post-create')
                <a class="btn btn-primary btn-sm" href="{{ route('posts.create') }}">
                    <i class="fa fa-plus"></i> Create New Post
                </a>
                @endcan
            </div>

            @if (session('success'))
                <div class="alert alert-success" role="alert"> 
                    {{ session('success') }}
                </div>
            @endif

            <div class="feed">
                @foreach ($posts as $post)
                <div class="post mb-4 p-3 bg-white border rounded shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <strong>{{ $post->user->name }}</strong>
                            <p class="text-muted mb-0">{{ $post->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                    <div class="post-content mb-3">
                        <p>{{ $post->text }}</p>
                        @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="post-image img-fluid">
                        @endif
                    </div>
                    <div class="post-actions d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                <button class="btn btn-light btn-sm me-2 like-button">
                                <i class="fa fa-thumbs-up"></i> Like (<span class="like-count">
                                    {{ is_array($likes = json_decode($post->likes, true)) ? count($likes) : 0 }}
                                </span>)
                            </button>
                    <button class="btn btn-light btn-sm me-2 comment-button">
                        <i class="fa fa-comment"></i> Comment
                    </button>
                    <button class="btn btn-light btn-sm">
                        <i class="fa fa-share"></i> Share
                    </button>
                </div>
                <div>
                    <!-- Buttons for show, edit, delete -->
                </div>
            </div>
            <div class="comment-section" style="display:none;">
    <textarea class="form-control comment-text" placeholder="Add a comment..."></textarea>
    <button class="btn btn-primary mt-2 submit-comment">Submit Comment</button>
    <div class="comments-list mt-3">
        @php
            $comments = json_decode($post->comments, true);
            if (!is_array($comments)) {
                $comments = [];
            }
        @endphp

        @foreach ($comments as $comment)
        <div class="comment">
            <!-- Assuming $comment is an associative array with 'text' and 'user_id' -->
            <p>{{ $comment['text'] }}</p>
            <small class="text-muted">Commented by user {{ $comment['user_id'] }}</small>
        </div>
        @endforeach
    </div>
</div>

        </div>
        @endforeach
    </div>

    {!! $posts->links() !!}
</div>
@endif
@endsection


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle like button click
    $('.like-button').on('click', function() {
        var postId = $(this).closest('.post').data('post-id');
        var button = $(this);

        console.log('Like button clicked. Post ID: ' + postId); // Debugging line

        $.ajax({
            url: '/posts/' + postId + '/like',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('AJAX request successful. Response:', response); // Debugging line
                if (response.status === 'success') {
                    button.find('.like-count').text(response.likes);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed. Status:', status, 'Error:', error); // Debugging line
            }
        });
    });
});

</script>
@endpush


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.like-button').on('click', function() {
        var postId = $(this).closest('.post').data('post-id');
        var button = $(this);
        
        $.ajax({
            url: '/posts/' + postId + '/like',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    button.find('.like-count').text(response.likes);
                }
            }
        });
    });

    $('.comment-button').on('click', function() {
        $(this).closest('.post').find('.comment-section').toggle();
    });

    $('.submit-comment').on('click', function() {
        var post = $(this).closest('.post');
        var postId = post.data('post-id');
        var commentText = post.find('.comment-text').val();
        
        $.ajax({
            url: '/posts/' + postId + '/comment',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                comment: commentText
            },
            success: function(response) {
                if (response.status === 'success') {
                    var commentsList = post.find('.comments-list');
                    commentsList.empty();
                    response.comments.forEach(function(comment) {
                        commentsList.append('<div class="comment"><strong>User ' + comment.user_id + ':</strong> ' + comment.text + '</div>');
                    });
                    post.find('.comment-text').val('');
                }
            }
        });
    });
});
</script>
@endpush



@push('styles')
<style>
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
</style>
@endpush
