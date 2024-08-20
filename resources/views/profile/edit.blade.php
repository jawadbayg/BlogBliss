@extends('layouts.app')

@section('content')
<section class="gradient-form" style="background-color: #eee;">
  <div class="container py-4 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 shadow mx-auto" style="max-width: 500px;">
          <div class="row g-0">
            <div class="col-lg-12 d-flex align-items-center">
              <div class="card-body p-md-5 mx-md-4">
                <div class="text-center">
                  <div class="image-container mb-4">
                    <img src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('storage/profile_pics/default-avatar.png') }}" alt="Profile Picture" class="img-fluid rounded-circle" id="avatarPreview">
                  </div>
                  <h1 id="profileTitle">Profile Update</h1>
                  <p>Update your profile information below.</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-outline mb-4">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus placeholder="Full Name" />
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="form-outline mb-4">
                    <label class="form-label" for="profile_pic">Profile Picture</label>
                    <input type="file" id="profile_pic" class="form-control @error('profile_pic') is-invalid @enderror" name="profile_pic" accept="image/*" onchange="previewImage(event)" />
                    @error('profile_pic')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="text-center pt-1 mb-5 pb-1">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container mt-4">
      <div class="row">
        <div class="col-md-6">
          <h2>Followers ({{ $followersCount }})</h2>
          @foreach($followers as $follower)
            <div class="follower-card mb-3">
              <div class="d-flex align-items-center">
                <img src="{{ $follower->profile_pic ? asset('storage/' . $follower->profile_pic) : asset('storage/profile_pics/default-avatar.png') }}" alt="{{ $follower->name }}" class="rounded-circle" style="width: 50px; height: 50px;">
                <div class="ms-3">
                  <p class="mb-0">{{ $follower->name }}</p>
                  @if (Auth::user()->isFollowing($follower))
                    <form action="{{ route('users.unfollow', $follower->id) }}" method="POST" class="follow-form" data-user-id="{{ $follower->id }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm" id="unfollow-btn">✓ Following</button>
                    </form>
                  @else
                    <form action="{{ route('users.follow', $follower->id) }}" method="POST" class="follow-form" data-user-id="{{ $follower->id }}">
                      @csrf
                      <button type="submit" class="btn btn-sm" id="follow-btn">+ Follow back</button>
                    </form>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="col-md-6">
          <h2>Following ({{ $followedCount }})</h2>
          @if ($followedCount > 0)
            <ul class="list-unstyled">
              @foreach ($followedUsers as $followedUser)
                <li class="d-flex align-items-center mb-2">
                  <img src="{{ $followedUser->profile_pic ? asset('storage/' . $followedUser->profile_pic) : asset('storage/profile_pics/default-avatar.png') }}" alt="User Image" class="rounded-circle" style="width: 50px; height: 50px;">
                  <span class="ms-3">{{ $followedUser->name }}</span>
                </li>
              @endforeach
            </ul>
          @else
            <p>You are not following anyone.</p>
          @endif
        </div>
      </div>
    </div>

  </div>
</section>
@endsection

@push('styles')
<style>
  .card {
    border-radius: 0.5rem;
  }

  .shadow {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .text-muted {
    color: #6c757d;
  }

  .gradient-form {
    background: linear-gradient(to right, #f8f9fa, #e9ecef);
  }

  .image-container {
    position: relative;
    width: 150px;
    height: 150px;
    overflow: hidden;
    border-radius: 50%;
    margin: 0 auto;
  }

  .image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }

  #follow-btn, #unfollow-btn {
    color: black;
    border: 1.5px solid black;
    font-weight: 700;
    border-radius: 30px;
    padding: 5px 10px; /* Adjust size of the button */
  }

  #follow-btn:hover, #unfollow-btn:hover {
    color: white;
    background-color: black;
  }

  .follower-card {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
  }
</style>
@endpush
