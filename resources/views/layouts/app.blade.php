<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

<style>
/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: black; 
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #b30000; 
}
</style>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/chatbot.js') }}"></script>


    <title>BlogBliss</title>
   <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<!-- Additional CSS and JS -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('path/to/datatables.js') }}"></script>
<script src="{{ asset('path/to/sweetalert2.all.min.js') }}"></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Englebert&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Amita:wght@400;700&family=Croissant+One&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Englebert&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vite CSS and JS -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
 <style>
    
        .navbar-brand {
            font-family: "Croissant One", serif;
            font-weight: 400;
            font-style: normal;
            font-size: 7vh;
        }

        .navbar-nav .nav-link {
            display: flex;
            align-items: center;
        }

        .user-avatar-navbar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .navbar-nav .nav-item {
            display: flex;
            align-items: center;
        }

        .dropdown-menu-end {
            min-width: 200px;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>


</head>

<body>
<div id="app">
        @unless(request()->is('login') || request()->is('register'))
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <a class="navbar-brand" href="{{ Auth::check() ? (Auth::user()->hasRole('Admin') ? url('/home') : url('/posts')) : url('/') }}">
                    BlogBliss
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Left side content -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                    <a class="nav-link" id="aboutus-btn" href="{{ route('about-us') }}">{{ __('About Us') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="login-btn" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                               
                            @endif
                        @else
                            @if(Auth::user()->hasRole('Admin'))
                                <!-- Admin specific links -->
                            @else
                                 @if(Auth::check() && Auth::user()->isFalse)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.userIndex') }}">My Posts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('posts.create') }}">
                                        <i class="fa-solid fa-pen-to-square fa-xl" style="margin-right: 2px;"></i>Write
                                    </a>    
                                </li>   
                                @endif

                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('storage/profile_pics/default-avatar.png') }}" alt="User Image" class="user-avatar-navbar">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        @endunless
      
        <main>
            @yield('content')
           
        </main>
    </div>
   
</body>
</html>
