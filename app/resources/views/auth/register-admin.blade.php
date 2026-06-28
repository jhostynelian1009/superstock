@extends('layouts.auth')

@section('title', 'Solicitar cuenta de administrador')

@section('content')
<h1 class="text-2xl font-semibold tracking-tight text-[var(--color-text-primary)] mb-2" style="font-family: 'Instrument Sans', sans-serif;">
    Solicitar acceso de administrador
</h1>
<p class="text-sm text-[var(--color-text-secondary)] mb-6">
    Completa tus datos. El administrador principal revisará la solicitud y, si la aprueba, te entregará un código para activar tu cuenta.
</p>

@if(session('success'))
    <div class="mb-4 p-4 rounded-md bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('register.admin') }}" method="POST" class="flex flex-col gap-4">
    @csrf

    <div class="flex flex-col">
        <label for="name" class="input-label">Nombre completo <span class="required">*</span></label>
        <input type="text" name="name" id="name" class="input-field @error('name') error @enderror"
               value="{{ old('name') }}" required autofocus>
        @error('name')<span class="error-message">{{ $message }}</span>@enderror
    </div>

    <div class="flex flex-col">
        <label for="document_number" class="input-label">Número de cédula / ID <span class="required">*</span></label>
        <input type="text" name="document_number" id="document_number" class="input-field @error('document_number') error @enderror"
               value="{{ old('document_number') }}" required>
        @error('document_number')<span class="error-message">{{ $message }}</span>@enderror
    </div>

    <div class="flex flex-col">
        <label for="phone" class="input-label">Teléfono <span class="required">*</span></label>
        <input type="tel" name="phone" id="phone" class="input-field @error('phone') error @enderror"
               value="{{ old('phone') }}" required>
        @error('phone')<span class="error-message">{{ $message }}</span>@enderror
    </div>

    <div class="flex flex-col">
        <label for="email" class="input-label">Correo electrónico <span class="required">*</span></label>
        <input type="email" name="email" id="email" class="input-field @error('email') error @enderror"
               value="{{ old('email') }}" required>
        @error('email')<span class="error-message">{{ $message }}</span>@enderror
    </div>

    <div class="flex flex-col">
        <label for="password" class="input-label">Contraseña <span class="required">*</span></label>
        <input type="password" name="password" id="password" class="input-field @error('password') error @enderror" required>
        @error('password')<span class="error-message">{{ $message }}</span>@enderror
    </div>

    <div class="flex flex-col">
        <label for="password_confirmation" class="input-label">Confirmar contraseña <span class="required">*</span></label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" required>
    </div>

    <button type="submit" class="btn-primary w-full h-[44px] mt-4 flex items-center justify-center">
        Enviar solicitud
    </button>
</form>

<div class="mt-6 text-center text-sm text-[var(--color-text-secondary)] border-t border-[var(--color-border-default)] pt-6 space-y-2">
    <p>
        ¿Ya tienes un código de acceso?
        <a href="{{ route('register.admin.verify') }}" class="font-medium text-[var(--color-brand-primary)] hover:underline">Actívalo aquí</a>
    </p>
    <p>
        <a href="{{ route('login') }}" class="font-medium text-[var(--color-brand-primary)] hover:underline">Volver al inicio de sesión</a>
    </p>
</div>
@endsection
