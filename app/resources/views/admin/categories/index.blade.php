@extends('layouts.admin')

@section('title', 'Categorías')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Categorías</h1>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Administra las categorías del catálogo.</p>
        </div>
        <a href="{{ route('admin.categorias.create') }}"
            class="inline-flex items-center justify-center rounded-sm bg-[#F53003] px-5 py-1.5 text-sm font-medium text-white transition-colors hover:bg-[#D42800]">
            Nueva categoría
        </a>
    </div>

    {{-- Búsqueda por Nombre --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form action="{{ route('admin.categorias.index') }}" method="GET" class="flex w-full max-w-md items-center gap-2">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por nombre..."
                    class="w-full rounded-sm border border-[#e3e3e0] bg-white pl-10 pr-4 py-2 text-sm text-[#1b1b18] focus:border-[#F53003] focus:outline-none focus:ring-2 focus:ring-[rgba(245,48,3,0.20)] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-[#706f6c] dark:text-[#A1A09A]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" />
                    </svg>
                </div>
            </div>
            <button type="submit"
                class="rounded-sm bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white">
                Buscar
            </button>
            @if (filled($search))
                <a href="{{ route('admin.categorias.index') }}"
                    class="inline-flex items-center justify-center rounded-sm border border-[#e3e3e0] px-4 py-2 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-[rgba(0,0,0,0.04)] dark:border-[#3E3E3A] dark:text-[#EDEDEC]"
                    title="Limpiar búsqueda">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    @include('admin.partials.flash')

    @if ($categories->isEmpty())
        <div class="rounded-lg border border-[#e3e3e0] bg-white p-12 text-center dark:border-[#3E3E3A] dark:bg-[#161615]">
            @if (filled($search))
                <div class="flex flex-col items-center justify-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#fff2f2] text-[#F53003] dark:bg-[#1D0002] dark:text-[#FF4433] mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-1">Sin resultados de búsqueda</h3>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] max-w-md mb-6">
                        No encontramos ninguna categoría que coincida con "{{ $search }}". Prueba con otros términos.
                    </p>
                    <a href="{{ route('admin.categorias.index') }}"
                        class="inline-flex items-center justify-center rounded-sm bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white">
                        Ver todas las categorías
                    </a>
                </div>
            @else
                <div class="flex flex-col items-center justify-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#fff2f2] text-[#F53003] dark:bg-[#1D0002] dark:text-[#FF4433] mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-1">No hay categorías</h3>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] max-w-md mb-6">
                        Comienza registrando tu primera categoría para organizar el catálogo de productos.
                    </p>
                    <a href="{{ route('admin.categorias.create') }}"
                        class="inline-flex items-center justify-center rounded-sm bg-[#F53003] px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-[#D42800]">
                        Registrar categoría
                    </a>
                </div>
            @endif
        </div>
    @else
        <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-left text-sm">
                    <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                        <tr>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Descripción</th>
                            <th class="px-4 py-3">Productos</th>
                            <th class="px-4 py-3">Fecha de creación</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            @php
                                $actionData = [
                                    'Categoría' => $category->name,
                                    'Descripción' => Str::limit($category->description ?? 'Sin descripción', 40),
                                    'Productos' => (string) $category->products_count,
                                    'Creado el' => $category->created_at->format('d/m/Y H:i'),
                                ];
                            @endphp
                            <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                                <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A] max-w-xs truncate" title="{{ $category->description }}">
                                    {{ $category->description ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $category->products_count }}</td>
                                <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $category->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-3">
                                        <button type="button"
                                            data-sc-action-open="edit"
                                            data-sc-action-url="{{ route('admin.categorias.edit', $category) }}"
                                            data-sc-action-title="Editar categoría"
                                            data-sc-action-data='@json($actionData)'
                                            class="text-sm font-medium text-[#1b1b18] underline-offset-4 hover:underline dark:text-[#EDEDEC]">
                                            Editar
                                        </button>
                                        <button type="button"
                                            data-sc-action-open="delete"
                                            data-sc-action-url="{{ route('admin.categorias.destroy', $category) }}"
                                            data-sc-action-title="Eliminar categoría"
                                            data-sc-action-data='@json($actionData)'
                                            class="text-sm font-medium text-[#F53003] underline-offset-4 hover:underline">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($categories->hasPages())
            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        @endif
    @endif
@endsection
