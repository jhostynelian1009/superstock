@extends('layouts.admin')

@section('title', 'Usuarios')
@section('breadcrumb', 'Usuarios')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Usuarios</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Gestiona los usuarios internos del sistema.</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}"
            class="inline-flex items-center justify-center rounded-sm bg-[#F53003] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-[#D42800]">
            Nuevo usuario
        </a>
    </div>

    @include('admin.partials.flash')

    <div class="mb-6 rounded-lg border border-[#e3e3e0] bg-white p-4 dark:border-[#3E3E3A] dark:bg-[#161615]">
        <form method="GET" action="{{ route('admin.usuarios.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end sm:gap-4">
            <div class="flex-1">
                <label for="search" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Buscar</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Nombre o correo..."
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white px-3 py-2 text-sm focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="rounded-sm bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A]">
                    Buscar
                </button>
                <a href="{{ route('admin.usuarios.index') }}"
                    class="inline-flex items-center justify-center rounded-sm border border-[#e3e3e0] px-3 py-2 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Rol</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Registro</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                @if ($user->role === 'Administrador')
                                    <span class="inline-flex rounded-full bg-[#F3BEC7] px-3 py-1 text-xs font-medium text-[#1b1b18] dark:bg-[#1D0002] dark:text-[#EDEDEC]">
                                        Administrador
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full border border-[#e3e3e0] px-3 py-1 text-xs font-medium text-[#706f6c] dark:border-[#3E3E3A] dark:text-[#A1A09A]">
                                        Empleado
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($user->is_active)
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.usuarios.edit', $user) }}"
                                        class="text-sm font-medium text-[#1b1b18] underline-offset-4 hover:underline dark:text-[#EDEDEC]">
                                        Editar
                                    </a>

                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.usuarios.toggle-active', $user) }}" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm font-medium text-[#F53003] underline-offset-4 hover:underline"
                                                onclick="return confirm('{{ $user->is_active ? '¿Desactivar este usuario?' : '¿Activar este usuario?' }}')">
                                                {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
@endsection
