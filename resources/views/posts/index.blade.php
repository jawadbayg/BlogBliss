@extends('layouts.app')

@section('content')
@if(Auth::user()->HasRole('User'))
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Posts</h2>
        </div>
        <div class="pull-right">
            @can('post-create')
            <a class="btn btn-success btn-sm mb-2" href="{{ route('posts.create') }}"><i class="fa fa-plus"></i> Create New Post</a>
            @endcan
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success" role="alert"> 
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Text</th>
        <th>Image</th>
        <th>Likes</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($posts as $post)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $post->text }}</td>
        <td>
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="max-width: 100px;">
            @else
                No Image
            @endif
        </td>
        <td>{{ $post->likes }}</td>
        <td>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                <a class="btn btn-info btn-sm" href="{{ route('posts.show', $post->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                @can('post-edit')
                <a class="btn btn-primary btn-sm" href="{{ route('posts.edit', $post->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                @endcan

                @csrf
                @method('DELETE')

                @can('post-delete')
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                @endcan
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endif

{!! $posts->links() !!}

<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection
