@extends('layouts.app')

@section('content')

@if(!Auth::check())
<header class="welcome-page-style" style="background-image: url('{{ asset($headerImage) }}');">
    <div class="header-heading">
        <h1>Human</h1>
        <h1>Stories & Ideas</h1>
    </div>
    <div class="subtitle">
        <p>A place to read, write, and deepen your understanding</p>
    </div>

    @guest
        <a href="{{route ('login')}}" class="start-reading-button">Start Reading</a>
    @endguest
</header>



<div class="container-feature-posts">
                <div class="container">
                    <div class="fp-header">
                        <p>Featured Article</p>
                    </div>
                    @if ($featuredPost)
                        <div class="row">
                            <div class="col-md-6" >
                                
                                <div class="fp-title">
                                <p>{{ $featuredPost->title }}</p>
                                </div>

                                <div class="fp-text">
                                
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($featuredPost->text), 550, '...') }}</p>
                                
                                <a href="{{ route('posts.showFeatured', $featuredPost->id) }}" class="readfull" id="openLoginPopup">Read Full</a>
                                </div>
                            
                            </div>
                            <div class="col-md-6" id="fp-image">
                            <img src="{{ asset('images/fp.jpg') }}" alt="Example Image" class="img-fluid">
                            </div>


                </div>
    @else
        <p>No featured post available.</p>
    @endif
</div>
<div class="thin-line"></div>

<div class="container">
    <div class="fp-header">
        <p>Best Rated Authors</p>
    </div>
    <div class="container">
        <div class="user-deck">
            @foreach ($topUsers as $user)
                <div class="user-card">
                @if ($user->profile_pic)
            <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="User Image" class="user-avatar" id="user-pic-welcome">
        @else
            <img src="{{ asset('storage/profile_pics/default-avatar.png') }}" alt="Default Avatar" class="user-avatar"  id="user-pic-welcome">
        @endif
                    <div class="user-name">{{ $user->name }}</div>
                    <p id="user-text">{{ $user->custom_text }}</p> 
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="thin-line"></div>
<div class="container text-center testimonialsHeading">
    Testimonials
</div>

<div class="container testimonials">
  <section id="testimonials">
    <figure class="testimonial daniel">
      <figcaption>
        <img src="https://github.com/annafkt/frontend-mentor-challenges/blob/main/challenges/testimonials-grid-section/images/image-daniel.jpg?raw=true" alt="" width="35">
        <p class="name">Daniel Clifford</p>
        <p class="title">Author</p>
      </figcaption>
      <blockquote>
        <h3 class="quote-part-1">BlogBliss has been a game-changer for my blogging journey. The intuitive design and powerful features have allowed me to express my thoughts and connect with my audience effortlessly</h3>
        <p class="quote-part-2">“I've seen a significant increase in engagement and readership since I started using BlogBliss. It's truly a fantastic platform for any blogger!”</p>
      </blockquote>
    </figure>
    <figure class="testimonial jonathan">
      <figcaption>
        <img src="https://github.com/annafkt/frontend-mentor-challenges/blob/main/challenges/testimonials-grid-section/images/image-jonathan.jpg?raw=true" alt="" width="35">
        <p class="name">Jonathan Walters</p>
        <p class="title">Verified Graduate</p>
      </figcaption>
      <blockquote>
        <h3 class="quote-part-1">"BlogBliss has transformed the way I manage my blog</h3>
        <p class="quote-part-2">“The seamless integration of SEO tools and analytics has made it easier for me to optimize my content and track my progress. The platform is not only reliable but also easy to use, making blogging a breeze!”</p>
      </blockquote>
    </figure>
    <figure class="testimonial jeanette">
      <figcaption>
        <img src="https://github.com/annafkt/frontend-mentor-challenges/blob/main/challenges/testimonials-grid-section/images/image-jeanette.jpg?raw=true" alt="" width="35">
        <p class="name">Jeanette Harmon</p>
        <p class="title">Verified Graduate</p>
      </figcaption>
      <blockquote>
        <h3 class="quote-part-1">BlogBliss is the perfect platform for both new and experienced bloggers</h3>
        <p class="quote-part-2">“Its sleek design and comprehensive features have made managing my blog a joy. The community is supportive, and the resources available are top-notch. I highly recommend BlogBliss to anyone looking to enhance their blogging experience!”</p>
      </blockquote>
    </figure>
    <figure class="testimonial patrick">
      <figcaption>
        <img src="https://github.com/annafkt/frontend-mentor-challenges/blob/main/challenges/testimonials-grid-section/images/image-patrick.jpg?raw=true" alt="" width="35">
        <p class="name">Patrick Abrams</p>
        <p class="title">Verified Graduate</p>
      </figcaption>
      <blockquote>
        <h3 class="quote-part-1">"I’ve tried numerous blogging platforms, but BlogBliss stands out with its user-friendly interface and customization options</h3>
        <p class="quote-part-2">“ The support team is incredibly responsive and helpful. Thanks to BlogBliss, I’ve been able to take my blog to the next level and grow my audience faster than I ever imagined!. As a writer, finding the right platform to showcase my work was crucial. BlogBliss exceeded my expectations with its beautiful templates and easy-to-use editor.”</p>
      </blockquote>
    </figure>
    <figure class="testimonial kira">
      <figcaption>
        <img src="https://github.com/annafkt/frontend-mentor-challenges/blob/main/challenges/testimonials-grid-section/images/image-kira.jpg?raw=true" alt="" width="35">
        <p class="name">Kira Whittle</p>
        <p class="title">Verified Graduate</p>
      </figcaption>
      <blockquote>
        <h3 class="quote-part-1">BlogBliss has been a fantastic partner in my blogging journey</h3>
        <p class="quote-part-2">“Switching to BlogBliss was one of the best decisions I’ve made for my blog. The ease of use and the powerful tools available have allowed me to focus on creating quality content rather than worrying about technical details. The support team is amazing, and the updates keep the platform fresh and innovative. Highly recommend BlogBliss to any serious blogger. The platform's intuitive interface and rich features have made content creation and management a breeze. The customization options allow me to make my blog truly unique, and the performance is always top-notch. My blog has never looked better, and my readers have noticed the difference. BlogBliss is the perfect platform for both new and experienced bloggers. Its sleek design and comprehensive features have made managing my blog a joy. The community is supportive, and the resources available are top-notch. I highly recommend BlogBliss to anyone looking to enhance their blogging experience!”</p>
      </blockquote>
    </figure>
  </section>
  
 
</div>
</div>
@include('partials.footer')

@endif

@endsection
