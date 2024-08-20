@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Post</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('posts.userIndex') }}"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control" placeholder="Enter post title" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Text:</strong>
                    <textarea id="mytextarea" class="form-control" name="text" placeholder="Enter post text" required>{{ old('text', $post->text) }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="tags">Tags:</label>
                <select name="tags[]" class="form-control" multiple>
                    <option value="science" {{ in_array('science', old('tags', explode(',', $post->tags))) ? 'selected' : '' }}>Science</option>
                    <option value="technology" {{ in_array('technology', old('tags', explode(',', $post->tags))) ? 'selected' : '' }}>Technology</option>
                    <option value="art" {{ in_array('art', old('tags', explode(',', $post->tags))) ? 'selected' : '' }}>Art</option>
                    <option value="fun" {{ in_array('fun', old('tags', explode(',', $post->tags))) ? 'selected' : '' }}>Fun</option>
                    <option value="education" {{ in_array('education', old('tags', explode(',', $post->tags))) ? 'selected' : '' }}>Education</option>
                    <option value="kids" {{ in_array('kids', old('tags', explode(',', $post->tags))) ? 'selected' : '' }}>Kids</option>
                    <option value="business" {{ in_array('business', old('tags', explode(',', $post->tags))) ? 'selected' : '' }}>Business</option>
                    <option value="selfImprovement" {{ in_array('selfImprovement', old('tags', explode(',', $post->tags))) ? 'selected' : '' }}>Self Improvement</option>
                    <option value="health" {{ in_array('health', old('tags', explode(',', $post->tags))) ? 'selected' : '' }}>Health</option>
                </select>
            </div>
           
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm mb-2 mt-2"><i class="fa-solid fa-floppy-disk"></i> Update Post</button>
            </div>
        </div>
    </form>
</div>

<!-- Include Froala Editor style -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

<!-- Include Froala Editor JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new FroalaEditor('#mytextarea', {
            imageUploadURL: '{{ route('upload.froala') }}',
            imageUploadParams: {
                _token: '{{ csrf_token() }}' 
            },
            
        });
    });
</script>
@endsection
