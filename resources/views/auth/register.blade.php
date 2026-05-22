@extends('layouts.auth')

@section('title', 'Register - Portal ISO 9001')

@section('content')
<div class="w-100" style="max-width: 400px;">
    <div class="card border-0" style="background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px); border: 1px solid rgba(168, 85, 247, 0.3) !important;">
        <div style="height: 3px; background: linear-gradient(90deg, #a855f7 0%, #ec4899 100%);"></div>
        
        <div class="card-body p-5">
            <h1 class="text-4xl fw-black text-white text-center mb-4">REGISTER</h1>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="form-label text-light fw-semibold">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control bg-dark border-secondary text-light @error('name') is-invalid @enderror"
                        placeholder="Nama anda"
                        required
                    />
                </div>

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
                    <label for="password" class="form-label text-light fw-semibold">Password (Min. 8 karakter)</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control bg-dark border-secondary text-light @error('password') is-invalid @enderror"
                            placeholder="Password"
                            required
                        />
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'eye-1')" style="border-color: #6b7280 !important;">
                            <span id="eye-1">👁️</span>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label text-light fw-semibold">Konfirmasi Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control bg-dark border-secondary text-light"
                            placeholder="Ulangi password"
                            required
                        />
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', 'eye-2')" style="border-color: #6b7280 !important;">
                            <span id="eye-2">👁️</span>
                        </button>
                    </div>
                </div>

                <!-- ID Card Number -->
                <div class="mb-4">
                    <label for="id_card" class="form-label text-light fw-semibold">ID Card</label>
                    <input
                        type="text"
                        id="id_card"
                        name="id_card"
                        value="{{ old('id_card') }}"
                        class="form-control bg-dark border-secondary text-light @error('id_card') is-invalid @enderror"
                        placeholder="Nomor ID Card"
                        required
                    />
                </div>

                <!-- Department Selection -->
                <div class="mb-4">
                    <label for="department_id" class="form-label text-light fw-semibold">Pilih Department</label>
                    <select
                        id="department_id"
                        name="department_id"
                        class="form-select bg-dark border-secondary text-light @error('department_id') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Pilih Department --</option>
                        @foreach (\App\Models\Department::all() as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Terms -->
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="agree" name="agree" required />
                    <label class="form-check-label text-light" for="agree">
                        Saya setuju dengan <a href="#" class="text-decoration-none" style="color: #a855f7;">Syarat & Ketentuan</a>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-lg w-100 text-white fw-bold" style="background: linear-gradient(90deg, #a855f7 0%, #ec4899 100%); border: none;">
                    Daftar
                </button>
            </form>

            <!-- Divider -->
            <div class="my-4 text-center">
                <span class="text-muted small">atau</span>
            </div>

            <!-- Login Link -->
            <a href="{{ route('login') }}" class="btn btn-outline-light w-100 fw-semibold">
                Sudah Punya Akun? Login
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-5">
        <p class="text-light small">Portal ISO 9001 © 2026</p>
    </div>
</div>

<script>
function togglePassword(fieldId, iconId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
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
