@extends('layouts.admin')

@section('title', 'Nuevo usuario')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Nuevo usuario</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Crea un nuevo usuario en el sistema.</p>
    </div>

    @include('admin.partials.flash')

    <div class="max-w-2xl rounded-lg bg-white p-6 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Nombre <span class="text-[#F53003]">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="150"
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('name') border-[#F53003] @enderror">
                @error('name')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Correo electrónico <span class="text-[#F53003]">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required maxlength="255"
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('email') border-[#F53003] @enderror">
                @error('email')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        Contraseña <span class="text-[#F53003]">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('password') border-[#F53003] @enderror">
                    @error('password')
                        <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        Confirmar contraseña <span class="text-[#F53003]">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">
                </div>
            </div>

            <div>
                <label for="role" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                    Rol <span class="text-[#F53003]">*</span>
                </label>
                <select name="role" id="role" required
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-4 py-3 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] @error('role') border-[#F53003] @enderror">
                    <option value="">Selecciona un rol</option>
                    <option value="Administrador" @selected(old('role') === 'Administrador')>Administrador</option>
                    <option value="Empleado" @selected(old('role') === 'Empleado')>Empleado</option>
                </select>
                @error('role')
                    <p class="mt-1 text-[13px] text-[#F53003]">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', true))
                    class="h-4 w-4 rounded-sm border-[#e3e3e0] text-[#F53003] focus:ring-[#F53003]">
                <label for="is_active" class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Usuario activo</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="rounded-sm bg-[#1b1b18] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white">
                    Crear usuario
                </button>
                <a href="{{ route('admin.usuarios.index') }}"
                    class="inline-flex items-center rounded-sm border border-[#e3e3e0] px-5 py-1.5 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
