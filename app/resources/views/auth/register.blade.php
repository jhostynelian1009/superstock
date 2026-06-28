@extends('layouts.auth')

@section('title', 'Registrarse')

@section('content')
<h1 class="text-2xl font-semibold tracking-tight text-[var(--color-text-primary)] mb-2" style="font-family: 'Instrument Sans', sans-serif;">
    Crea tu cuenta de cliente
</h1>
<p class="text-sm text-[var(--color-text-secondary)] mb-6">
    Regístrate para comprar snacks y ver el historial de tus pedidos.
</p>

<form action="{{ route('register') }}" method="POST" class="flex flex-col gap-4">
    @csrf

    <div class="flex flex-col">
        <label for="name" class="input-label">
            Nombre completo <span class="required">*</span>
        </label>
        <input type="text" name="name" id="name"
               class="input-field @error('name') error @enderror"
               placeholder="Nombre y Apellido"
               value="{{ old('name') }}"
               required autocomplete="name" autofocus>
        @error('name')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex flex-col">
        <label for="document_number" class="input-label">
            Número de cédula / ID <span class="required">*</span>
        </label>
        <input type="text" name="document_number" id="document_number"
               class="input-field @error('document_number') error @enderror"
               placeholder="Ej. 1723456789"
               value="{{ old('document_number') }}"
               required>
        @error('document_number')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex flex-col">
        <label for="phone" class="input-label">
            Teléfono <span class="required">*</span>
        </label>
        <input type="tel" name="phone" id="phone"
               class="input-field @error('phone') error @enderror"
               placeholder="Ej. 0998123456"
               value="{{ old('phone') }}"
               required autocomplete="tel">
        @error('phone')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex flex-col">
        <label for="email" class="input-label">
            Correo electrónico <span class="required">*</span>
        </label>
        <input type="email" name="email" id="email"
               class="input-field @error('email') error @enderror"
               placeholder="ejemplo@correo.com"
               value="{{ old('email') }}"
               required autocomplete="username">
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
               placeholder="Mínimo 8 caracteres"
               required autocomplete="new-password">
        @error('password')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex flex-col">
        <label for="password_confirmation" class="input-label">
            Confirmar contraseña <span class="required">*</span>
        </label>
        <input type="password" name="password_confirmation" id="password_confirmation"
               class="input-field"
               placeholder="Repite la contraseña"
               required autocomplete="new-password">
    </div>

    <button type="submit" class="btn-primary w-full h-[44px] mt-4 flex items-center justify-center">
        Crear cuenta de cliente
    </button>
</form>

<div class="mt-6 text-center text-sm text-[var(--color-text-secondary)] border-t border-[var(--color-border-default)] pt-6">
    ¿Ya tienes una cuenta?
    <a href="{{ route('login') }}" class="font-medium text-[var(--color-brand-primary)] hover:underline">
        Inicia sesión aquí
    </a>
</div>
@endsection
