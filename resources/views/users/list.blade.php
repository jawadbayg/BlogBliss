@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Connect with people</h2>
    <div class="user-list">
        @foreach ($users as $user)
            <div class="user-item">
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
    <button type="submit" class="btn btn-sm" id="follow-btn">
        <span class="btn-text">{{ auth()->user()->isFollowing($user) ? 'Following' : '+ Follow' }}</span>
        <span class="btn-icon" style="display: {{ auth()->user()->isFollowing($user) ? 'inline' : 'none' }};">✓</span>
    </button>
</form>

            </div>
        @endforeach
    </div>
</div>
@endsection

<style>
   .user-list {
    display: flex;
    flex-direction: column;
}

.user-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.user-name {
    font-size: 1.2em;
}

.follow-form {
    margin-left: auto;
}

.follow-btn-l {
    color: black;
    border: 1.5px solid black;
    font-weight: 700;
    border-radius: 30px;
    padding: 5px 10px;
    display: flex;
    align-items: center;
    background-color: white;
    border: none;
}

.follow-btn:hover {
    color: white;
    background-color: black;
}

.btn-icon {
    margin-left: 5px;
}

</style>
