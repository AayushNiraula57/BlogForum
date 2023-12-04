<nav class="navbar navbar-light navbar-expand-lg mb-5 sticky-top" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand mr-auto" href="/blog">BlogApp</a>
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
                <li class="nav-item mx-5">
                    <form action="/blog">
                        <input type="search" class="form-control" placeholder="Find Blogs Here" name="search" value="">
                    </form>
                </li>
                @else
                @auth
                <li class="nav-item">
                    <a class="nav-link">Hello,{{Auth::user()->name}} | </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('blog.create')}}">Add Post | </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('blog.user_posts',Auth::user()->id)}}">My Posts | </a>
                </li>
                <li class="nav-item mx-5">
                    <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                </li>
                <li class="nav-item mx-5">
                    <form action="/blog">
                        <input type="search" class="form-control" placeholder="Find Blogs Here" name="search" value="">
                    </form>
                </li>
                @endauth
                @endguest
            </ul>
        </div>
    </div>
</nav>