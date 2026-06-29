@extends('layouts.admin')

@section('title', 'Detalle del movimiento')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Detalle del movimiento</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Información del registro de inventario.</p>
        </div>
        <a href="{{ route('admin.movimientos.index') }}"
            class="inline-flex items-center rounded-sm border border-[#e3e3e0] px-5 py-1.5 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
            Volver
        </a>
    </div>

    @include('admin.partials.flash')

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Información principal --}}
        <div class="lg:col-span-2 rounded-lg bg-white p-6 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615]">
            <h2 class="mb-4 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Información del movimiento</h2>

            <div class="space-y-4">
                <div>
                    <p class="text-xs font-medium uppercase text-[#706f6c] dark:text-[#A1A09A]">Fecha y hora</p>
                    <p class="mt-1 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        {{ $movimiento->occurred_at->format('d de F \d\e Y, H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase text-[#706f6c] dark:text-[#A1A09A]">Producto</p>
                    <p class="mt-1 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                        {{ $movimiento->product?->name }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-medium uppercase text-[#706f6c] dark:text-[#A1A09A]">Tipo de movimiento</p>
                        <p class="mt-1">
                            @if ($movimiento->movement_type === 'Entrada')
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Entrada
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Salida
                                </span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase text-[#706f6c] dark:text-[#A1A09A]">Cantidad</p>
                        <p class="mt-1 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ number_format($movimiento->quantity, 3) }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase text-[#706f6c] dark:text-[#A1A09A]">Motivo</p>
                    <p class="mt-1 text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                        {{ $movimiento->reason }}
                    </p>
                </div>

                @if ($movimiento->reference)
                    <div>
                        <p class="text-xs font-medium uppercase text-[#706f6c] dark:text-[#A1A09A]">Referencia</p>
                        <p class="mt-1 text-sm font-mono text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ $movimiento->reference }}
                        </p>
                    </div>
                @endif

                @if ($movimiento->supplier)
                    <div>
                        <p class="text-xs font-medium uppercase text-[#706f6c] dark:text-[#A1A09A]">Proveedor</p>
                        <p class="mt-1 text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                            {{ $movimiento->supplier->name }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Información del usuario y registro --}}
        <div class="space-y-4">
            <div class="rounded-lg bg-white p-4 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615]">
                <h3 class="mb-3 text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Usuario</h3>
                <p class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">{{ $movimiento->user?->name }}</p>
                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ $movimiento->user?->email }}</p>
            </div>

            <div class="rounded-lg bg-white p-4 shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615]">
                <h3 class="mb-3 text-sm font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Información de registro</h3>
                <div class="space-y-2 text-xs">
                    <div>
                        <p class="font-medium text-[#706f6c] dark:text-[#A1A09A]">Creado:</p>
                        <p class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ $movimiento->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-slate-50 dark:bg-slate-900/60 p-4 dark:bg-slate-900/50">
                <p class="text-xs font-medium text-[#1b1b18] dark:text-[#EDEDEC]">ID del movimiento</p>
                <p class="mt-1 font-mono text-sm text-[#706f6c] dark:text-[#A1A09A]">#{{ $movimiento->id }}</p>
            </div>
        </div>
    </div>
@endsection
