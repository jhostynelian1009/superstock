@extends('layouts.auth')

@section('title', 'Iniciar Sesión — SuperStock')

@section('content')
<h1 class="text-2xl font-semibold tracking-tight text-[var(--color-text-primary)] mb-2" style="font-family: 'Instrument Sans', sans-serif;">
    SuperStock
</h1>
<p class="text-sm text-[var(--color-text-secondary)] mb-6">
    Acceso interno al sistema de gestión de inventario.
</p>

@if(session('status'))
    <div class="mb-4 p-4 rounded-md bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">
        {{ session('status') }}
    </div>
@endif

<form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4">
    @csrf

    <div class="flex flex-col">
        <label for="email" class="input-label">
            Correo electrónico <span class="required">*</span>
        </label>
        <input type="email" name="email" id="email"
               class="input-field @error('email') error @enderror"
               placeholder="usuario@superstock.ec"
               value="{{ old('email') }}"
               required autofocus autocomplete="username">
        @error('email')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex flex-col">
        <label for="password" class="input-label">
            Contraseña <span class="required">*</span>
        </label>
        <input type="password" name="password" id="password"
               class="input-field @error('password') error @enderror"
               placeholder="••••••••"
               required autocomplete="current-password">
        @error('password')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex items-center justify-between mt-1">
        <label class="flex items-center gap-2 text-sm text-[var(--color-text-secondary)] select-none">
            <input type="checkbox" name="remember" class="w-4 h-4 accent-[var(--color-brand-primary)] border-[var(--color-border-default)] rounded-[var(--radius-sm)]">
            <span>Recordarme</span>
        </label>
    </div>

    <button type="submit" id="login-submit-btn" class="btn-primary w-full h-[44px] mt-4 flex items-center justify-center">
        Iniciar Sesión
    </button>
</form>

<div class="mt-6 text-center text-sm text-[var(--color-text-secondary)] border-t border-[var(--color-border-default)] pt-6">
    <p>
        ¿Necesitas acceso de administrador?
        <a href="{{ route('register.admin') }}" class="font-medium text-[var(--color-brand-primary)] hover:underline">
            Solicitar cuenta
        </a>
    </p>
</div>
@endsection
