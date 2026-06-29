@extends('layouts.admin')

@section('title', 'Solicitudes de administrador')
@section('breadcrumb', 'Solicitudes admin')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Solicitudes de administrador</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Aprueba o rechaza quién puede crear una cuenta de administrador.
            </p>
        </div>
        @if($pendingCount > 0)
            <span class="inline-flex rounded-full bg-[#F3BEC7] px-4 py-2 text-sm font-medium text-[#1b1b18] dark:bg-[#1D0002] dark:text-[#EDEDEC]">
                {{ $pendingCount }} pendiente{{ $pendingCount === 1 ? '' : 's' }}
            </span>
        @endif
    </div>

    @include('admin.partials.flash')

    @if(session('generated_admin_code'))
        <div class="admin-access-code-card" role="status" aria-live="polite">
            <div class="admin-access-code-card__header">
                <div class="admin-access-code-card__icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="admin-module-label admin-module-label--active">Código generado</span>
                        <span class="admin-module-label admin-module-label--info">Válido 24 h</span>
                    </div>
                    <h2 class="admin-access-code-card__title">Acceso aprobado para nueva cuenta de administrador</h2>
                    <p class="admin-access-code-card__email">{{ session('generated_admin_email') }}</p>
                </div>
            </div>

            <div class="admin-access-code-card__code-wrap">
                <span class="admin-access-code-card__code-label">Código de activación</span>
                <p class="admin-access-code-card__code" id="admin-access-code-value">{{ session('generated_admin_code') }}</p>
            </div>

            <p class="admin-access-code-card__meta">
                Comparte este código con la persona solicitante. Debe ingresarlo junto con su correo en la página de activación.
            </p>

            <a href="{{ route('register.admin.verify') }}"
               class="admin-access-code-card__link"
               target="_blank"
               rel="noopener noreferrer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                Abrir página de activación
            </a>
        </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Solicitante</th>
                        <th class="px-4 py-3">Contacto</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3">
                                <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $request->name }}</div>
                                <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">ID: {{ $request->document_number }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div>{{ $request->email }}</div>
                                <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ $request->phone }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium
                                    @if($request->status === 'pending') bg-amber-100 text-amber-900 dark:bg-amber-950/30 dark:text-amber-300
                                    @elseif($request->status === 'approved') bg-blue-100 text-blue-900 dark:bg-blue-950/30 dark:text-blue-300
                                    @elseif($request->status === 'completed') bg-green-100 text-green-900 dark:bg-green-950/30 dark:text-green-300
                                    @else bg-red-100 text-red-900 dark:bg-red-950/30 dark:text-red-300 @endif">
                                    {{ $request->statusLabel() }}
                                </span>
                                @if($request->isApproved() && $request->isExpired())
                                    <div class="text-xs text-red-600 mt-1">Código expirado</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $request->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                @if($request->isPending())
                                    <div class="flex justify-end items-end gap-4">
                                        <form action="{{ route('admin.solicitudes-admin.approve', $request) }}" method="POST" class="flex flex-col gap-2">
                                            @csrf
                                            <div class="flex flex-col gap-1 p-2.5 rounded-sm border border-[#e3e3e0] bg-[#FDFDFC] dark:border-[#3E3E3A] dark:bg-[#161615] text-left text-xs text-[#1b1b18] dark:text-[#EDEDEC] min-w-[240px]">
                                                <span class="font-semibold text-xs mb-1 text-[#706f6c] dark:text-[#A1A09A]">Módulos permitidos:</span>
                                                <div class="grid grid-cols-2 gap-x-2 gap-y-1">
                                                    <label class="flex items-center gap-1.5 cursor-pointer">
                                                        <input type="checkbox" name="permissions[]" value="productos" checked class="rounded border-gray-300"> Productos
                                                    </label>
                                                    <label class="flex items-center gap-1.5 cursor-pointer">
                                                        <input type="checkbox" name="permissions[]" value="categorias" checked class="rounded border-gray-300"> Categorías
                                                    </label>
                                                    <label class="flex items-center gap-1.5 cursor-pointer">
                                                        <input type="checkbox" name="permissions[]" value="proveedores" checked class="rounded border-gray-300"> Proveedores
                                                    </label>
                                                    <label class="flex items-center gap-1.5 cursor-pointer">
                                                        <input type="checkbox" name="permissions[]" value="inventario" checked class="rounded border-gray-300"> Inventario
                                                    </label>
                                                    <label class="flex items-center gap-1.5 cursor-pointer">
                                                        <input type="checkbox" name="permissions[]" value="movimientos" checked class="rounded border-gray-300"> Movimientos
                                                    </label>
                                                    <label class="flex items-center gap-1.5 cursor-pointer">
                                                        <input type="checkbox" name="permissions[]" value="usuarios" class="rounded border-gray-300"> Usuarios
                                                    </label>
                                                    <label class="flex items-center gap-1.5 cursor-pointer col-span-2">
                                                        <input type="checkbox" name="permissions[]" value="solicitudes-admin" class="rounded border-gray-300"> Solicitudes Admin
                                                    </label>
                                                </div>
                                            </div>
                                            <button type="submit" class="rounded-sm bg-[#16a34a] px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">
                                                Aprobar y generar código
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.solicitudes-admin.reject', $request) }}" method="POST" class="inline-flex items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="rejection_reason" value="Solicitud rechazada por el administrador principal.">
                                            <button type="submit" class="rounded-sm border border-[#e3e3e0] px-3 py-1.5 text-xs font-medium text-[#706f6c] hover:bg-[#fff2f2] dark:border-[#3E3E3A] dark:text-[#A1A09A]">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                @elseif($request->isApproved())
                                    <div class="flex items-center justify-end gap-3">
                                        <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                            @if($request->approver)
                                                Por {{ $request->approver->name }}
                                            @endif
                                        </span>
                                        <form action="{{ route('admin.solicitudes-admin.resend', $request) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rounded-sm bg-brand-primary px-3 py-1.5 text-xs font-medium text-white hover:bg-brand-primary-hover">
                                                Regenerar código
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-right text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                        @if($request->approver)
                                            Por {{ $request->approver->name }}
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                No hay solicitudes registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div class="px-4 py-3 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
@endsection
