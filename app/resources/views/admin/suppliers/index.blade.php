@extends('layouts.admin')

@section('title', 'Proveedores')
@section('breadcrumb', 'Proveedores')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Proveedores</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Gestiona los proveedores del sistema.</p>
        </div>
        <a href="{{ route('admin.proveedores.create') }}"
            class="inline-flex items-center justify-center rounded-sm bg-brand-primary px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-brand-primary-hover">
            Nuevo proveedor
        </a>
    </div>

    @include('admin.partials.flash')

    {{-- Buscador --}}
    <form method="GET" action="{{ route('admin.proveedores.index') }}" class="mb-4">
        <div class="flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Buscar por razón social, RUC, contacto o correo…"
                class="w-full max-w-sm rounded-sm border border-[#e3e3e0] bg-white px-4 py-2 text-sm text-[#1b1b18] outline-none transition focus:border-brand-primary focus:ring-1 focus:ring-brand-primary dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]"
                aria-label="Buscar proveedor"
            >
            <button type="submit"
                class="inline-flex items-center justify-center rounded-sm bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1b1b18]">
                Buscar
            </button>
            @if($search)
                <a href="{{ route('admin.proveedores.index') }}"
                    class="inline-flex items-center justify-center rounded-sm border border-[#e3e3e0] px-4 py-2 text-sm font-medium text-[#706f6c] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#A1A09A]">
                    Limpiar
                </a>
            @endif
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-900/60 text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-slate-900/50 dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Razón Social</th>
                        <th class="px-4 py-3">RUC</th>
                        <th class="px-4 py-3">Contacto</th>
                        <th class="px-4 py-3">Teléfono</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        @php
                            $actionData = [
                                'Razón Social' => $supplier->business_name,
                                'RUC'          => $supplier->tax_identifier ?? '—',
                                'Contacto'     => $supplier->contact_name ?? '—',
                                'Estado'       => $supplier->is_active ? 'Activo' : 'Inactivo',
                            ];
                        @endphp
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                {{ $supplier->business_name }}
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $supplier->tax_identifier ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $supplier->contact_name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $supplier->phone ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $supplier->email ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @if($supplier->is_active)
                                    <span class="badge badge--activo">
                                        <span class="badge-dot"></span>Activo
                                    </span>
                                @else
                                    <span class="badge badge--inactivo">
                                        <span class="badge-dot"></span>Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-3">
                                    <button type="button"
                                        data-sc-action-open="edit"
                                        data-sc-action-url="{{ route('admin.proveedores.edit', $supplier) }}"
                                        data-sc-action-title="Editar proveedor"
                                        data-sc-action-data='@json($actionData)'
                                        class="text-sm font-medium text-[#1b1b18] underline-offset-4 hover:underline dark:text-[#EDEDEC]">
                                        Editar
                                    </button>
                                    <button type="button"
                                        data-sc-action-open="delete"
                                        data-sc-action-url="{{ route('admin.proveedores.destroy', $supplier) }}"
                                        data-sc-action-title="Eliminar proveedor"
                                        data-sc-action-data='@json($actionData)'
                                        class="text-sm font-medium text-brand-primary underline-offset-4 hover:underline">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2 text-[#706f6c] dark:text-[#A1A09A]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 opacity-40">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                                    </svg>
                                    @if($search)
                                        <p class="font-medium">Sin resultados para "{{ $search }}"</p>
                                        <p class="text-sm">Intenta con otro término de búsqueda.</p>
                                    @else
                                        <p class="font-medium">No hay proveedores registrados</p>
                                        <p class="text-sm">Crea el primer proveedor para comenzar.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($suppliers->hasPages())
        <div class="mt-6">
            {{ $suppliers->links() }}
        </div>
    @endif
@endsection
