@extends('layouts.app')

@section('content')
@if(Auth::user()->hasRole('Admin'))

@include('partials.admin-nav')

@else
    @if(Auth::check() && !Auth::user()->isFalse)
        <div class="alert alert-warning" role="alert">
            Your application is under review.
        </div>
    @else
        <div class="container">
            <h1>Your Profile is approved by Admin</h1>
            <a href="{{ route('posts.index') }}" class="btn btn-primary">go to site</a>
        </div>
    @endif
@endif
@endsection
