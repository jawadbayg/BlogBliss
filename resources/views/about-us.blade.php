@extends('layouts.app')

@section('content')

<div class="container about-us">
        <div class="row">
            <div class="col-md-6 text-content">
                <h1>Everyone has a story to tell.</h1>
                <p>
                    BlogBliss is a home for human stories and ideas. Here, anyone can share insightful perspectives, useful knowledge, and life wisdom with the world—without building a mailing list or a following first. The internet is noisy and chaotic; BlogBliss is quiet yet full of insight. It’s simple, beautiful, collaborative, and helps you find the right audience for whatever you have to say.
                </p>
                <p>
                    We believe that what you read and write matters. Words can divide or empower us, inspire or discourage us. In a world where the most sensational and surface-level stories often win, we’re building a system that rewards depth, nuance, and time well spent. A space for thoughtful conversation more than drive-by takes, and substance over packaging.
                </p>
                <p>
                    Ultimately, our goal is to deepen our collective understanding of the world through the power of writing.
                </p>
                <p>
                    Over 100 million people connect and share their wisdom on BlogBliss every month. Many are professional writers, but just as many aren’t — they’re CEOs, computer scientists, U.S. presidents, amateur novelists, and anyone burning with a story they need to get out into the world. They write about what they’re working on, what’s keeping them up at night, what they’ve lived through, and what they’ve learned that the rest of us might want to know too.
                </p>
            </div>
            <div class="col-md-6 image-content">
                <img src="{{ asset('images/1.png') }}" alt="About Us">

                <div class="col-md-10 text-center mx-auto">
    <a href="#" id="aboutus1btn" class="btn btn-primary">See Our Community</a>
</div>
<div class="col-md-10 text-center mx-auto">
    <a href="#" id="aboutus1btn" class="btn btn-primary">Start Writing</a>
</div>
<div class="col-md-10 text-center mx-auto">
    <a href="#" id="aboutus1btn" class="btn btn-primary">Become a Member</a>
</div>

            </div>
        </div>
    </div>
    @include('partials.footer')
    <style>

        body, p {
           
            color: black;
        }

        .about-us {
            font-family: "Barlow Semi Condensed", sans-serif;
            padding: 20px;
            background-color: white;
        }

      

        .about-us .image-content img {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .about-us .text-content p {
            font-family: "Barlow Semi Condensed", sans-serif;
            font-size: 22px;
            line-height: 1.6;
            color: black;
        }

        .about-us .text-content h1 {
            font-family: "Barlow Semi Condensed", sans-serif;
            font-size: 80px;
            font-weight: 900;
        }

        #aboutus1btn {
            font-family: "Barlow Semi Condensed", sans-serif;
    height: 150px;
    margin-top:20px;
    background-color: black;
    color: white;
    border: none;
    padding: 0; /* Remove padding to use flexbox centering */
    border-radius: 5px;
    font-size: 26px;
    font-weight: 700;
    text-decoration: none;
    width: 100%; /* Full width of the column */
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
    display: flex;
    align-items: center; /* Vertically center text */
    justify-content: center; /* Horizontally center text */
    text-align: center; /* Ensure text is centered within the button */
}

#aboutus1btn:hover {
    font-family: "Barlow Semi Condensed", sans-serif;
    color:black;
    background-color: white;
    border:2px solid black /* Darker shade for hover effect */
}



    </style>
    @endsection