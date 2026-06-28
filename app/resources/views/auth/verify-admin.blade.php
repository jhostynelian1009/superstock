@extends('layouts.auth')

@section('title', 'Activar cuenta de administrador')

@section('content')
<h1 class="text-2xl font-semibold tracking-tight text-[var(--color-text-primary)] mb-2" style="font-family: 'Instrument Sans', sans-serif;">
    Activar cuenta de administrador
</h1>
<p class="text-sm text-[var(--color-text-secondary)] mb-6">
    Ingresa el correo de tu solicitud y el código que te entregó el administrador principal.
</p>

@if(session('success'))
    <div class="mb-4 p-4 rounded-md bg-green-50 border-l-4 border-green-500 text-green-700 text-sm">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('register.admin.verify') }}" method="POST" class="flex flex-col gap-4">
    @csrf

    <div class="flex flex-col">
        <label for="email" class="input-label">Correo de la solicitud <span class="required">*</span></label>
        <input type="email" name="email" id="email" class="input-field @error('email') error @enderror"
               value="{{ old('email') }}" required autofocus>
        @error('email')<span class="error-message">{{ $message }}</span>@enderror
    </div>

    <div class="flex flex-col">
        <label for="verification_code" class="input-label">Código de acceso <span class="required">*</span></label>
        <input type="text" name="verification_code" id="verification_code"
               class="input-field @error('verification_code') error @enderror uppercase"
               placeholder="Ej. ABC-482" value="{{ old('verification_code') }}" required>
        @error('verification_code')<span class="error-message">{{ $message }}</span>@enderror
    </div>

    <button type="submit" class="btn-primary w-full h-[44px] mt-4 flex items-center justify-center">
        Activar cuenta de administrador
    </button>
</form>

<div class="mt-6 text-center text-sm text-[var(--color-text-secondary)] border-t border-[var(--color-border-default)] pt-6 space-y-2">
    <p>
        ¿Aún no enviaste tu solicitud?
        <a href="{{ route('register.admin') }}" class="font-medium text-[var(--color-brand-primary)] hover:underline">Solicitar acceso</a>
    </p>
    <p>
        <a href="{{ route('login') }}" class="font-medium text-[var(--color-brand-primary)] hover:underline">Ir al inicio de sesión</a>
    </p>
</div>
@endsection
