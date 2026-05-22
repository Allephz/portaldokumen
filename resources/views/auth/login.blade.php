@extends('layouts.auth')

@section('title', 'Login - Portal ISO 9001')

@section('content')
<div class="w-100" style="max-width: 400px;">
    <div class="card border-0" style="background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px); border: 1px solid rgba(168, 85, 247, 0.3) !important;">
        <div style="height: 3px; background: linear-gradient(90deg, #a855f7 0%, #ec4899 100%);"></div>
        
        <div class="card-body p-5">
            <h1 class="text-4xl fw-black text-white text-center mb-4">LOGIN</h1>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label text-light fw-semibold">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control bg-dark border-secondary text-light @error('email') is-invalid @enderror"
                        placeholder="user@email.com"
                        required
                    />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label text-light fw-semibold">Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control bg-dark border-secondary text-light @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            required
                        />
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()" style="border-color: #6b7280 !important;">
                            <span id="eye-icon">👁️</span>
                        </button>
                    </div>
                </div>

                <!-- Remember -->
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" />
                    <label class="form-check-label text-light" for="remember">Ingat saya</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-lg w-100 text-white fw-bold" style="background: linear-gradient(90deg, #a855f7 0%, #ec4899 100%); border: none;">
                    Login
                </button>
            </form>

            <!-- Divider -->
            <div class="my-4 text-center">
                <span class="text-muted small">atau</span>
            </div>

            <!-- Register Link -->
            <a href="{{ route('register') }}" class="btn btn-outline-light w-100 fw-semibold">
                Buat Akun Baru
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-5">
        <p class="text-light small">Portal ISO 9001 © 2026</p>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '🙈';
    } else {
        input.type = 'password';
        icon.textContent = '👁️';
    }
}
</script>
@endsection
