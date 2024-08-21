@extends('layouts.app')

@section('no-navbar') @endsection
@section('content')
<section class="gradient-form" style="background-color: #eee;">
  <div class="container py-4 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 shadow mx-auto" style="max-width: 500px;">
          <div class="row g-0">
            <!-- Login Form Section -->
            <div class="col-lg-12 d-flex align-items-center">
              <div class="card-body p-md-5 mx-md-4">
                <div class="text-center">
                <a href="/" id="blogbliss-link">
                    <h1 id="blogbliss">BlogBliss</h1>
                </a>

                  <h4 class="mt-1 mb-3 pb-1">We are The BlogBliss team</h4>
                  <p>Please login to your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                  @csrf

                  <div class="form-outline mb-4">
                    <label class="form-label" for="email">Username</label>
                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email address" />
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" />
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="text-center mb-4">
                    <button type="submit" style="width: 100%; background-color: black; color: white; border: none; padding: 10px;">Log in</button>
                  </div>

                  <div class="text-center mb-4">
                    @if (Route::has('password.request'))
                      <a class="text-muted" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <a href="{{ route('register') }}" class="btn btn-secondary" style="background-color: black;">Create new</a>
                  </div>
                </form>
                <!-- <a href="{{ url('auth/google') }}" class="btn btn-primary">Login with Google</a> -->

              </div>
            </div>
          </div>
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

  .btn-black {
    background-color: black;
    color: white;
    border: none;
  }

  .btn-black:hover {
    background-color: #333;
    color: white;
  }

  .btn-block {
    width: 100%;
  }
</style>
@endpush
