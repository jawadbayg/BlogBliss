@extends('layouts.app')

@section('content')
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
                            <button class="btn btn-light btn-sm me-2">
                                <i class="fa fa-thumbs-up"></i> Like
                            </button>
                            <button class="btn btn-light btn-sm me-2">
                                <i class="fa fa-comment"></i> Comment
                            </button>
                            <button class="btn btn-light btn-sm">
                                <i class="fa fa-share"></i> Share
                            </button>
                        </div>
                        <div>
                            <a class="btn btn-info btn-sm" href="{{ route('posts.show', $post->id) }}">
                                <i class="fa-solid fa-list"></i> Show
                            </a>
                            @can('post-edit')
                            <a class="btn btn-primary btn-sm" href="{{ route('posts.edit', $post->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            @endcan
                            @can('post-delete')
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {!! $posts->links() !!}

            <p class="text-center text-primary mt-4"><small>Tutorial by ItSolutionStuff.com</small></p>
        </div>
    </div>
@endif
@endsection

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
