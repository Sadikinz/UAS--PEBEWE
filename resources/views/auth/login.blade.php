<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Craftfolio</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="card">
        <p class="brand">Craft<span>folio</span></p>
        <p class="subtitle">Login ke akun kamu</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror

            <label>Password</label>
            <div class="password-wrap">
                <input type="password" name="password" id="password" required>
                <button type="button" class="toggle-pw" onclick="togglePassword()">Lihat</button>
            </div>

            <div class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="margin-bottom:0; text-transform:none; font-weight:400;">Ingat saya</label>
            </div>

            <button type="submit">Masuk</button>
        </form>

        <div class="divider">atau</div>

        <a href="{{ route('register') }}" class="btn-register">Daftar Akun Baru</a>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const btn = document.querySelector('.toggle-pw');
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'Sembunyikan';
            } else {
                input.type = 'password';
                btn.textContent = 'Lihat';
            }
        }
    </script>
</body>
</html>
