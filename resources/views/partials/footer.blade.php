<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>About Us</h5>
                <p>
                    BlogBliss is a platform for sharing insightful perspectives, useful knowledge, and life wisdom with the world. Learn more about us and our mission.
                </p>
                <a href="{{ route('about-us') }}" class="btn btn-link">Learn More</a>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="#">Posts</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact Us</h5>
                <p>
                    Email: support@blogbliss.com<br>
                    Phone: (123) 456-7890
                </p>
            </div>
        </div>
    </div>
    <div class="text-center py-3">
        &copy; {{ date('Y') }} BlogBliss. All rights reserved.
    </div>
</footer>

<style>
    .btn-link{
        text-decoration: none;
        color:  #6c757d;
    }
    .footer {
        padding-top:15px;
        background-color: white;
        border-top: 1px solid #e9ecef;
    }

    .footer h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .footer p {
        font-size: 14px;
        color: #6c757d;
    }

    .footer ul {
        padding-left: 0;
        list-style: none;
    }

    .footer ul li {
        margin-bottom: 10px;
    }

    .footer ul li a {
        color: #6c757d; /* Change link color to match the text color */
        text-decoration: none; /* Remove underline */
    }

    .footer ul li a:hover {
        text-decoration: none; /* Remove underline on hover */
        color: #495057; /* Darker grey color on hover */
    }

    .footer .text-center {
        background-color: #e9ecef;
        color: #6c757d;
    }
</style>
