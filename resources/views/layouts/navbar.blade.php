<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container text-center">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav w-100">
              <li class="nav-item active">
                <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('show.add_book')}}">Add book</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('profile')}}">Profile</a>
              </li>
            </ul>
            <ul class="navbar-nav w-100 justify-content-end">
              <li class="nav-item">
                <a class="nav-link" href="{{route('logout')}}">{{Auth::user()->first_name}} {{Auth::user()->last_name}} (Logout)</a>
              </li>
          </div>
    </div>
  </nav>