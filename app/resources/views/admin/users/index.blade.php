@extends('layouts.admin')

@section('title', 'Usuarios')
@section('breadcrumb', 'Usuarios')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Clientes registrados</h1>
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Usuarios que se registraron para comprar en el catálogo.</p>
    </div>

    @include('admin.partials.flash')

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Cédula / ID</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Teléfono</th>
                        <th class="px-4 py-3">Pedidos</th>
                        <th class="px-4 py-3">Registro</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $client->name }}</td>
                            <td class="px-4 py-3">{{ $client->document_number ?? '—' }}</td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $client->email }}</td>
                            <td class="px-4 py-3">{{ $client->phone ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-[#F3BEC7] px-3 py-1 text-xs font-medium text-[#1b1b18] dark:bg-[#1D0002] dark:text-[#EDEDEC]">
                                    {{ $client->orders_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $client->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                No hay clientes registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
            <div class="px-4 py-3 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
@endsection
