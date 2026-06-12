<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard — Craftfolio')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout-user.css') }}">
    @yield('styles')
</head>
<body>
<div class="sidebar">
    <a href="{{ route('home') }}" class="sidebar-brand">Craft<span>folio</span></a>
    <nav class="sidebar-nav">
        <p class="nav-label">Menu</p>
        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('user.posts.create') }}" class="{{ request()->routeIs('user.posts.create') ? 'active' : '' }}">Tulis Post</a>
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
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
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
