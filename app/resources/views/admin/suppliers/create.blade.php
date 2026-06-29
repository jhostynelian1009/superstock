@extends('layouts.admin')

@section('title', 'Nuevo Proveedor')
@section('breadcrumb', 'Proveedores')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Nuevo Proveedor</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Completa los datos del proveedor.</p>
        </div>
        <a href="{{ route('admin.proveedores.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-[#706f6c] underline-offset-4 hover:underline dark:text-[#A1A09A]">
            &larr; Volver al listado
        </a>
    </div>

    @include('admin.partials.flash')

    <div class="mx-auto max-w-2xl rounded-lg border border-[#e3e3e0] bg-white p-8 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A] dark:bg-[#161615]">
        <form method="POST" action="{{ route('admin.proveedores.store') }}" novalidate>
            @csrf

            {{-- Razón Social --}}
            <div class="mb-5">
                <label for="business_name" class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Razón Social <span class="text-brand-primary">*</span>
                </label>
                <input
                    type="text"
                    id="business_name"
                    name="business_name"
                    value="{{ old('business_name') }}"
                    maxlength="180"
                    required
                    class="w-full rounded-sm border px-4 py-2 text-sm outline-none transition
                        {{ $errors->has('business_name') ? 'border-brand-primary focus:ring-brand-primary' : 'border-[#e3e3e0] focus:border-brand-primary focus:ring-brand-primary' }}
                        bg-white text-[#1b1b18] focus:ring-1 dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
                    aria-describedby="{{ $errors->has('business_name') ? 'business_name_error' : '' }}"
                >
                @error('business_name')
                    <p id="business_name_error" class="mt-1 text-xs text-brand-primary">{{ $message }}</p>
                @enderror
            </div>

            {{-- RUC / Identificador tributario --}}
            <div class="mb-5">
                <label for="tax_identifier" class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    RUC / Identificador tributario
                </label>
                <input
                    type="text"
                    id="tax_identifier"
                    name="tax_identifier"
                    value="{{ old('tax_identifier') }}"
                    maxlength="30"
                    class="w-full rounded-sm border px-4 py-2 text-sm outline-none transition
                        {{ $errors->has('tax_identifier') ? 'border-brand-primary focus:ring-brand-primary' : 'border-[#e3e3e0] focus:border-brand-primary focus:ring-brand-primary' }}
                        bg-white text-[#1b1b18] focus:ring-1 dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
                    aria-describedby="{{ $errors->has('tax_identifier') ? 'tax_identifier_error' : '' }}"
                >
                @error('tax_identifier')
                    <p id="tax_identifier_error" class="mt-1 text-xs text-brand-primary">{{ $message }}</p>
                @enderror
            </div>

            {{-- Persona de contacto --}}
            <div class="mb-5">
                <label for="contact_name" class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Persona de contacto
                </label>
                <input
                    type="text"
                    id="contact_name"
                    name="contact_name"
                    value="{{ old('contact_name') }}"
                    maxlength="150"
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-2 text-sm text-[#1b1b18] outline-none transition focus:border-brand-primary focus:ring-1 focus:ring-brand-primary dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
                >
            </div>

            {{-- Teléfono --}}
            <div class="mb-5">
                <label for="phone" class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Teléfono
                </label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    maxlength="30"
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-2 text-sm text-[#1b1b18] outline-none transition focus:border-brand-primary focus:ring-1 focus:ring-brand-primary dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
                >
            </div>

            {{-- Correo electrónico --}}
            <div class="mb-5">
                <label for="email" class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Correo electrónico
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    maxlength="255"
                    class="w-full rounded-sm border px-4 py-2 text-sm outline-none transition
                        {{ $errors->has('email') ? 'border-brand-primary focus:ring-brand-primary' : 'border-[#e3e3e0] focus:border-brand-primary focus:ring-brand-primary' }}
                        bg-white text-[#1b1b18] focus:ring-1 dark:border-[#3E3E3A] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]"
                    aria-describedby="{{ $errors->has('email') ? 'email_error' : '' }}"
                >
                @error('email')
                    <p id="email_error" class="mt-1 text-xs text-brand-primary">{{ $message }}</p>
                @enderror
            </div>

            {{-- Estado --}}
            <div class="mb-8">
                <label class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Estado</label>
                <div class="flex items-center gap-3">
                    <input
                        type="hidden"
                        name="is_active"
                        value="0"
                    >
                    <label class="relative inline-flex cursor-pointer items-center gap-3">
                        <input
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="peer sr-only"
                        >
                        <div class="peer h-6 w-11 rounded-full bg-[#e3e3e0] after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-brand-primary peer-checked:after:translate-x-full peer-focus:ring-2 peer-focus:ring-brand-primary dark:bg-[#3E3E3A]"></div>
                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Activo</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.proveedores.index') }}"
                    class="sc-btn sc-btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="sc-btn sc-btn-accent">
                    Guardar proveedor
                </button>
            </div>
        </form>
    </div>
@endsection
