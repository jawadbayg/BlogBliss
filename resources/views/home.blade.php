@extends('layouts.app')

@section('content')
@if(Auth::user()->hasRole('Admin'))

@include('partials.admin-nav')
<!-- 
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            Total Users
        </div>
        <div class="card-body text-center">
            <h3>{{ $userCount }}</h3>
        </div>
    </div>
</div> -->

@else
    @if(Auth::check() && !Auth::user()->isFalse)
        <div class="alert alert-warning" role="alert">
            Your application is under review.
        </div>
    @else
        <div class="container">
            <h1>User Dashboard</h1>
            <a href="{{ route('posts.index') }}" class="btn btn-primary">Manage posts</a>
        </div>
    @endif
@endif
@endsection
