<nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand mr-auto" href="#">BlogApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register_user') }}">Register</a>
                </li>
                @else
                @auth
                <li class="nav-item">
                    <a class="nav-link">Hello,{{Auth::user()->name}} | </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/blog/create/post">Add Post | </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/blog/show/{{Auth::user()->id}}">My Posts | </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                </li>
                @endauth
                @endguest
            </ul>
        </div>
    </div>
</nav>