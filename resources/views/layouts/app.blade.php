<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Craftfolio')</title>
    <link rel="stylesheet" href="{{ asset('css/layout-app.css') }}">
    @yield('styles')
</head>
<body>

<nav>
    <a href="{{ route('home') }}" class="nav-brand">Craft<span>folio</span></a>
    
    <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
        @foreach(\App\Models\Category::all() as $cat)
            <li>
                <a href="{{ route('post.category', $cat->slug) }}" class="{{ request()->is('category/'.$cat->slug) ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="nav-profile">
        @auth
            <div class="profile-btn" onclick="toggleDropdown()">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="profile-name">{{ auth()->user()->name }}</span>
                <span class="chevron">▾</span>
            </div>
            <div class="dropdown" id="dropdown">
                <p class="dropdown-name">{{ auth()->user()->name }}</p>
                <p class="dropdown-email">{{ auth()->user()->email }}</p>
                <div class="dropdown-divider"></div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Dashboard Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="dropdown-item">Dashboard Saya</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item dropdown-logout">Logout</button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="profile-btn">
                <div class="avatar avatar-guest">?</div>
            </a>
        @endauth
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer>
    <p>&copy; {{ date('Y') }} <span>Craftfolio</span> — Blog untuk Graphic Designer</p>
</footer>

<script>
    function toggleDropdown() {
        document.getElementById('dropdown').classList.toggle('show');
    }
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-profile')) {
            const d = document.getElementById('dropdown');
            if (d) d.classList.remove('show');
        }
    });
</script>

@yield('scripts')
</body>
</html>
