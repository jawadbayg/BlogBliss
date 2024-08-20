@if(Auth::check() && !Auth::user()->isFalse)
        <div class="alert alert-warning" role="alert">
            Your application is under review.
        </div>







        @else







<div class="container">
  <div class="row">
    <div class="col-md-3 mb-3">
        <div class="card">
          <div class="card-content">
            <div class="card-top">
              <span class="card-title">Total Users</span>
              <!-- <p>Total Users</p> -->
            </div>
            <div class="card-bottom">
              <p></p>
              <svg width="32" viewBox="0 -960 960 960" height="32" xmlns="http://www.w3.org/2000/svg">
                <path d="M226-160q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19ZM226-414q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19ZM226-668q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Z"></path>
              </svg>
            </div>
          </div>
          <div class="card-image">
          <div class="row align-items-center">
                <div class="col-auto">
                    <i class="fa fa-user" style="font-size: 32px;"></i>
                </div>
                <div class="col-auto">
                    <h1><strong>{{ $userCount }}</strong></h1>
                </div>
</div>


          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card">
          <div class="card-content">
            <div class="card-top">
              <span class="card-title">Total Posts</span>
              <!-- <p>Total Posts</p> -->
            </div>
            <div class="card-bottom">
              <p></p>
              <svg width="32" viewBox="0 -960 960 960" height="32" xmlns="http://www.w3.org/2000/svg">
                <path d="M226-160q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19ZM226-414q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19ZM226-668q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Z"></path>
              </svg>
            </div>
          </div>
          <div class="card-image">
          <div class="row align-items-center">
                <div class="col-auto">
                    <i class="fa fa-user" style="font-size: 32px;"></i>
                </div>
                <div class="col-auto">
                    <h1><strong>{{ $postCount }}</strong></h1>
                </div>
</div>
          </div>
        </div>
        
      </a>
</div>


<div class="col-md-3 mb-3">
        <div class="card">
          <div class="card-content">
            <div class="card-top">
              <span class="card-title">User Requests</span>
              <!-- <p>Total Posts</p> -->
            </div>
            <div class="card-bottom">
              <p></p>
              <svg width="32" viewBox="0 -960 960 960" height="32" xmlns="http://www.w3.org/2000/svg">
                <path d="M226-160q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19ZM226-414q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19ZM226-668q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Z"></path>
              </svg>
            </div>
          </div>
          <div class="card-image">
          <div class="row align-items-center">
                <div class="col-auto">
                    <i class="fas fa-user-clock" style="font-size: 32px;"></i>
                </div>
                <div class="col-auto">
                    <h1><strong>{{ $pendingCount }}</strong></h1>
                </div>
</div>
          </div>
        </div>
        
      </a>
</div>




<div class="col-md-3 mb-3">
        <div class="card">
          <div class="card-content">
            <div class="card-top">
              <span class="card-title">Post Requests</span>
              <!-- <p>Total Posts</p> -->
            </div>
            <div class="card-bottom">
              <p></p>
              <svg width="32" viewBox="0 -960 960 960" height="32" xmlns="http://www.w3.org/2000/svg">
                <path d="M226-160q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19ZM226-414q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19ZM226-668q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Zm254 0q-28 0-47-19t-19-47q0-28 19-47t47-19q28 0 47 19t19 47q0 28-19 47t-47 19Z"></path>
              </svg>
            </div>
          </div>
          <div class="card-image">
          <div class="row align-items-center">
                <div class="col-auto">
                    <i class="far fa-file-alt" style="font-size: 32px;"></i>
                </div>
                <div class="col-auto">
                    <h1><strong>{{ $pendingPost }}</strong></h1>
                </div>
</div>
          </div>
        </div>
        
      </a>
</div>




<div class="admin-navbar">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center">
                <a href="{{ route('users.index') }}" class="btn btn-large btn-users">
                    <i class="fas fa-users"></i><br>
                    Manage Users
                </a>
            </div>
            
            <div class="col-md-4 text-center">
                <a href="{{ route('posts.index') }}" class="btn btn-large btn-posts">
                    <i class="fas fa-file-alt"></i><br>
                    Manage Posts
                </a>
            </div>

            <div class="col-md-4 text-center">
                <a href="{{ route('roles.index') }}" class="btn btn-large btn-roles">
                    <i class="fas fa-user-shield"></i><br>
                    Manage Roles
                </a>
            </div>
        </div>
    </div>
</div>



    @endif




<style>

    /* From Uiverse.io by Samalander0 */ 
.card {
  width: 220px;
  background: white;
  color: black;
  position: relative;
  border-radius: 00px;
  padding: 2em;
  transition: transform 0.4s ease;
}

.card .card-content {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 5em;
  height: 100%;
  transition: transform 0.4s ease;
}

.card .card-top, .card .card-bottom {
  display: flex;
  justify-content: space-between;
}

.card .card-top p, .card .card-top .card-title, .card .card-bottom p, .card .card-bottom .card-title {
  margin: 0;
}

.card .card-title {
  font-weight: bold;
}

.card .card-top p, .card .card-bottom p {
  font-weight: 600;
}

.card .card-bottom {
  align-items: flex-end;
}

.card .card-image {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  display: grid;
  place-items: center;
  pointer-events: none;
}

.card .card-image svg {
  width: 4em;
  height: 4em;
  transition: transform 0.4s ease;
}

.card:hover {
  cursor: pointer;
  transform: scale(0.97);
}

.card:hover .card-content {
  transform: scale(0.96);
}

.card:hover .card-image svg {
  transform: scale(1.05);
}

.card:active {
  transform: scale(0.9);
}
.admin-navbar {
   <h5 style="font-family: 'Barlow Semi Condensed', sans-serif;">Recommended topics</h5>

    background-color: white; /* Dark background */
    padding: 20px 0;
}

.admin-navbar .btn-large {
    display: block;
    width: 100%;
    padding: 20px 0;
    font-size: 1.5em;
    color: #fff;
    text-decoration: none;
    border: 2px solid transparent;
    transition: background-color 0.3s, border-color 0.3s;
}

.admin-navbar .btn-large:hover {
    background-color: #495057; /* Darker hover effect */
    border-color: #fff; /* White border on hover */
}

.admin-navbar .btn-users {
    background-color: #007bff; /* Blue */
}

.admin-navbar .btn-roles {
    background-color: #28a745; /* Green */
}

.admin-navbar .btn-posts {
    background-color: #dc3545; /* Red */
}

.admin-navbar i {
    font-size: 2em;
}

.admin-navbar .btn-large br {
    display: block;
    margin-bottom: 10px;
}

    </style>