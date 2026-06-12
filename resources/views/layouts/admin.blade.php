<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — Craftfolio')</title>
    <link rel="stylesheet" href="{{ asset('css/layout-admin.css') }}">
    @yield('styles')
</head>
<body>

<div class="sidebar">
    <a href="{{ route('home') }}" class="sidebar-brand">Craft<span>folio</span></a>
    <nav class="sidebar-nav">
        <p class="nav-label">Menu</p>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
            Posts
        </a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            Categories
        </a>
        <a href="{{ route('admin.posts.pending') }}" class="{{ request()->routeIs('admin.posts.pending') ? 'active' : '' }}">
            Pending Posts
            @php $pendingCount = \App\Models\Post::where('is_published', 0)->whereHas('user')->count(); @endphp
            @if($pendingCount > 0)
                <span style="background:#FF3C00; color:#fff; font-size:10px; font-weight:700; padding:2px 7px; border-radius:10px; margin-left:auto;">{{ $pendingCount }}</span>
            @endif
        </a>
        <p class="nav-label">Site</p>
        <a href="{{ route('home') }}" target="_blank">Lihat Website</a>
    </nav>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="main">
    <div class="topbar">
        <p class="topbar-title">@yield('page-title', 'Dashboard')</p>
        <p class="topbar-user">{{ auth()->user()->name }}</p>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        @yield('content')
    </div>
</div>

@yield('scripts')
</body>
</html>
