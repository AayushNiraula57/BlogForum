<nav class="navbar navbar-light navbar-expand-lg" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand mr-0" href="{{route('admin.dashboard')}}">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register_user') }}">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Hello,{{session('name')}} | </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="/blog/create/post">Add Post | </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.signout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>