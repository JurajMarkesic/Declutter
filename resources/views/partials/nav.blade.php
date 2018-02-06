<nav class="navbar navbar-expand-lg navbar-light mb-2 mt-2">
    <div class="container">
        <div class="navbar-brand">
            @include('partials.search')
        </div>

        <button class="navbar-toggler mt-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        CATEGORY
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        @foreach($categories as $category)
                            <a href="/categories/{{$category->id}}" class="dropdown-item">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </li>

                @if (Auth::guest())
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">LOGIN</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">REGISTER</a></li>
                @else
                    <li class="nav-item"><a href="/home" class="nav-link">HOME</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a href="/profile/{{Auth::id()}}" class="dropdown-item">Profile</a>
                            <a href="{{ route('logout') }}" class="dropdown-item"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>

                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>