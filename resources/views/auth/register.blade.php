<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Craftfolio</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="card">
        <p class="brand">Craft<span>folio</span></p>
        <p class="subtitle">Buat akun baru</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror

            <label>Password</label>
            <div class="password-wrap">
                <input type="password" name="password" id="password" required>
                <button type="button" class="toggle-pw" onclick="togglePassword('password')">Lihat</button>
            </div>
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror

            <label>Konfirmasi Password</label>
            <div class="password-wrap">
                <input type="password" name="password_confirmation" id="password_confirmation" required>
                <button type="button" class="toggle-pw" onclick="togglePassword('password_confirmation')">Lihat</button>
            </div>

            <button type="submit">Daftar</button>
        </form>

        <div class="divider">atau</div>

        <a href="{{ route('login') }}" class="btn-login">Sudah punya akun? Masuk</a>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const btns = document.querySelectorAll('.toggle-pw');
            const btn = id === 'password' ? btns[0] : btns[1];
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
