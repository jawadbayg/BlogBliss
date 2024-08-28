@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>My Posts</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success btn-sm" href="{{ route('posts.create') }}"><i class="fa fa-plus"></i> Create New Post</a>
            </div>
        </div>
    </div>

    @if ($posts->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Post Title</th>
                        <th>Description</th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ \Illuminate\Support\Str::limit(strip_tags($post->text), 200, '...') }}</td>
                            <!-- <td>{{ Str::limit( $post->text, 100 ) }}</td> -->
                            <td class="actions-column">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">
    <i class="fa fa-trash"></i>
</button>


                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <strong>No posts found.</strong>
        </div>
    @endif
</div>
@endsection

