@extends('layouts.admin')

@section('title', 'Usuarios')
@section('breadcrumb', 'Usuarios')

@section('content')
    <style>
        dialog::backdrop {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
        }
    </style>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Gestión de Usuarios</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Administra cuentas de usuarios del sistema.</p>
        </div>
    </div>

    @include('admin.partials.flash')

    {{-- Buscador y filtros --}}
    <form method="GET" action="{{ route('admin.usuarios.index') }}" class="mb-4 flex flex-wrap gap-2">
        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Buscar por nombre, email o cédula…"
            class="w-full max-w-sm rounded-sm border border-[#e3e3e0] bg-white px-4 py-2 text-sm text-[#1b1b18] outline-none transition focus:border-[#F53003] focus:ring-1 focus:ring-[#F53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]"
            aria-label="Buscar usuario"
        >
        <select
            name="role"
            class="rounded-sm border border-[#e3e3e0] bg-white px-3 py-2 text-sm text-[#1b1b18] outline-none focus:border-[#F53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]"
            aria-label="Filtrar por rol"
        >
            <option value="">Todos los roles</option>
            <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ ($roleFilter ?? '') === \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Administrador</option>
            <option value="{{ \App\Models\User::ROLE_EMPLOYEE }}" {{ ($roleFilter ?? '') === \App\Models\User::ROLE_EMPLOYEE ? 'selected' : '' }}>Empleado</option>
        </select>
        <button type="submit"
            class="inline-flex items-center justify-center rounded-sm bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1b1b18]">
            Filtrar
        </button>
        @if($search || $roleFilter)
            <a href="{{ route('admin.usuarios.index') }}"
               class="inline-flex items-center justify-center rounded-sm border border-[#e3e3e0] px-4 py-2 text-sm font-medium text-[#706f6c] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#A1A09A]">
                Limpiar
            </a>
        @endif
    </form>

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Cédula / ID</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Teléfono</th>
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
                            <td class="px-4 py-3 font-mono text-[#706f6c] dark:text-[#A1A09A]">{{ $user->document_number ?? '—' }}</td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->phone ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $user->isAdmin() ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($user->is_active)
                                    <span class="badge badge--activo"><span class="badge-dot"></span>Activo</span>
                                @else
                                    <span class="badge badge--cancelado"><span class="badge-dot"></span>Inactivo</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                @if($user->id !== auth()->id() && !$user->isPrimaryAdmin())
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Modal Dialog for Permissions --}}
                                        <dialog id="modal-permissions-{{ $user->id }}" class="rounded-lg p-5 border border-[#e3e3e0] bg-white dark:border-[#3E3E3A] dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] max-w-sm w-full shadow-lg">
                                            <form method="POST" action="{{ route('admin.usuarios.update-permissions', $user) }}" class="flex flex-col text-left">
                                                @csrf
                                                <h3 class="text-base font-semibold mb-3 border-b border-[#e3e3e0] pb-2 dark:border-[#3E3E3A]">Permisos para: {{ $user->name }}</h3>
                                                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mb-4">Selecciona los módulos a los que este usuario tendrá acceso:</p>
                                                
                                                <div class="flex flex-col gap-2">
                                                    <label class="flex items-center gap-2 cursor-pointer text-sm">
                                                        <input type="checkbox" name="permissions[]" value="productos" {{ $user->hasPermissionTo('productos') ? 'checked' : '' }} class="rounded border-gray-300 text-[#F53003] focus:ring-[#F53003]">
                                                        <span>Productos</span>
                                                    </label>
                                                    <label class="flex items-center gap-2 cursor-pointer text-sm">
                                                        <input type="checkbox" name="permissions[]" value="categorias" {{ $user->hasPermissionTo('categorias') ? 'checked' : '' }} class="rounded border-gray-300 text-[#F53003] focus:ring-[#F53003]">
                                                        <span>Categorías</span>
                                                    </label>
                                                    <label class="flex items-center gap-2 cursor-pointer text-sm">
                                                        <input type="checkbox" name="permissions[]" value="proveedores" {{ $user->hasPermissionTo('proveedores') ? 'checked' : '' }} class="rounded border-gray-300 text-[#F53003] focus:ring-[#F53003]">
                                                        <span>Proveedores</span>
                                                    </label>
                                                    <label class="flex items-center gap-2 cursor-pointer text-sm">
                                                        <input type="checkbox" name="permissions[]" value="inventario" {{ $user->hasPermissionTo('inventario') ? 'checked' : '' }} class="rounded border-gray-300 text-[#F53003] focus:ring-[#F53003]">
                                                        <span>Inventario</span>
                                                    </label>
                                                    <label class="flex items-center gap-2 cursor-pointer text-sm">
                                                        <input type="checkbox" name="permissions[]" value="movimientos" {{ $user->hasPermissionTo('movimientos') ? 'checked' : '' }} class="rounded border-gray-300 text-[#F53003] focus:ring-[#F53003]">
                                                        <span>Movimientos</span>
                                                    </label>
                                                    <label class="flex items-center gap-2 cursor-pointer text-sm">
                                                        <input type="checkbox" name="permissions[]" value="usuarios" {{ $user->hasPermissionTo('usuarios') ? 'checked' : '' }} class="rounded border-gray-300 text-[#F53003] focus:ring-[#F53003]">
                                                        <span>Usuarios</span>
                                                    </label>
                                                    <label class="flex items-center gap-2 cursor-pointer text-sm">
                                                        <input type="checkbox" name="permissions[]" value="solicitudes-admin" {{ $user->hasPermissionTo('solicitudes-admin') ? 'checked' : '' }} class="rounded border-gray-300 text-[#F53003] focus:ring-[#F53003]">
                                                        <span>Solicitudes Admin</span>
                                                    </label>
                                                </div>

                                                <div class="flex justify-end gap-2 mt-6 border-t border-[#e3e3e0] pt-3 dark:border-[#3E3E3A]">
                                                    <button type="button" onclick="document.getElementById('modal-permissions-{{ $user->id }}').close()" class="px-3 py-1.5 border border-[#e3e3e0] rounded text-xs font-medium dark:border-[#3E3E3A] hover:bg-gray-50 dark:hover:bg-gray-800">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit" class="px-3 py-1.5 bg-[#F53003] text-white rounded text-xs font-medium hover:bg-[#D22602]">
                                                        Guardar Cambios
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <button onclick="document.getElementById('modal-permissions-{{ $user->id }}').showModal()" class="text-xs font-medium rounded px-2 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-950 dark:text-blue-300 transition">
                                            Permisos
                                        </button>

                                        <form method="POST" action="{{ route('admin.usuarios.toggle-status', $user) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit"
                                                class="text-xs font-medium rounded px-2 py-1 transition
                                                    {{ $user->is_active
                                                        ? 'bg-red-50 text-red-700 hover:bg-red-100 dark:bg-red-950 dark:text-red-300'
                                                        : 'bg-green-50 text-green-700 hover:bg-green-100 dark:bg-green-950 dark:text-green-300' }}"
                                                onclick="return confirm('¿Seguro que deseas {{ $user->is_active ? 'desactivar' : 'activar' }} a {{ addslashes($user->name) }}?')">
                                                {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-[#706f6c]">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-[#706f6c] dark:text-[#A1A09A]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 opacity-40">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    @if($search || $roleFilter)
                                        <p class="font-medium">Sin resultados para el filtro aplicado</p>
                                        <p class="text-sm">Intenta con otro término o rol.</p>
                                    @else
                                        <p class="font-medium">No hay usuarios registrados</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-4 py-3 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
