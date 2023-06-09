<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if(Auth::user()->image)
                <img src="{{ asset('storage/user/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}" style="max-width: 35px; border-radius: 50%;">
            @else
                <i class="fas fa-user fa-fw"></i>
            @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ route('landing') }}">Landing Page</a></li>
            <li><a class="dropdown-item" href="#!">Setting</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                </form> 
            </li>
        </ul>
    </li>
</ul>
