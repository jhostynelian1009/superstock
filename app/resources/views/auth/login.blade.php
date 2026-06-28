@extends('layouts.auth')

@section('title', 'Acceso Interno')

@section('content')
<div class="animate-fade-in-up">
    <!-- Header -->
    <div class="login-form-header">
        <h1 class="login-form-title">Acceso interno a SuperStock</h1>
        <p class="login-form-subtitle">Ingresa tus credenciales para gestionar el inventario.</p>
    </div>

    <!-- Session Status Alert -->
    @if(session('status'))
        <div class="mb-5 p-4 rounded bg-[var(--color-bg-muted)] border-l-4 border-[var(--color-success)] text-[var(--color-success)] text-sm flex items-center gap-2 animate-fade-in">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <!-- Email -->
        <div class="flex flex-col">
            <label for="email" class="input-label">
                Correo electrónico <span class="required">*</span>
            </label>
            <div class="input-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                <input type="email" name="email" id="email"
                       class="input-field @error('email') error @enderror"
                       placeholder="ejemplo@superstock.com"
                       value="{{ old('email') }}"
                       required autofocus autocomplete="username">
            </div>
            @error('email')
                <span class="error-message">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Password -->
        <div class="flex flex-col">
            <label for="password" class="input-label">
                Contraseña <span class="required">*</span>
            </label>
            <div class="input-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-2.25 10.5h13.5c.621 0 1.125-.504 1.125-1.125V11.25c0-.621-.504-1.125-1.125-1.125H5.25c-.621 0-1.125.504-1.125 1.125v7.875c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                <input type="password" name="password" id="password"
                       class="input-field @error('password') error @enderror"
                       placeholder="••••••••"
                       required autocomplete="current-password">
                <button type="button" class="password-toggle" onclick="togglePasswordVisibility()" aria-label="Mostrar contraseña">
                    <svg id="eye-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            @error('password')
                <span class="error-message">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Remember me -->
        <div class="flex items-center justify-between mt-1">
            <label class="flex items-center gap-2 text-sm text-[var(--color-text-secondary)] select-none cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 accent-[var(--color-brand-primary)] border-[var(--color-border-default)] rounded-[var(--radius-sm)] cursor-pointer">
                <span>Recordarme en este dispositivo</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-primary w-full h-[44px] mt-2 flex items-center justify-center">
            Iniciar Sesión
        </button>
    </form>
</div>

<!-- Scripts for interactive features -->
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.815 7.815 3 3m-3-3a10.493 10.493 0 0 1-5.14 1.488c-4.756 0-8.773-3.162-10.065-7.498a10.524 10.524 0 0 1 2.37-4.148m11.83 11.83a4.5 4.5 0 0 1-6.364-6.364m6.364 6.364-6.364-6.364" />
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            `;
        }
    }


</script>
@endsection
