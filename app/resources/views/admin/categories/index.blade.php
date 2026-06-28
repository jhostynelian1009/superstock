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

    @include('admin.partials.flash')

    <div class="overflow-hidden rounded-lg border border-[#e3e3e0] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:border-[#3E3E3A]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="bg-[#fff2f2] text-xs font-medium uppercase tracking-wide text-[#706f6c] dark:bg-[#1D0002] dark:text-[#A1A09A]">
                    <tr>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Productos</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        @php
                            $actionData = [
                                'Categoría' => $category->name,
                                'Slug' => $category->slug,
                                'Productos' => (string) $category->products_count,
                            ];
                        @endphp
                        <tr class="{{ $loop->even ? 'bg-[#FDFDFC] dark:bg-[#0a0a0a]' : 'bg-white dark:bg-[#161615]' }} border-b border-[#e3e3e0] hover:bg-[rgba(245,48,3,0.04)] dark:border-[#3E3E3A]">
                            <td class="px-4 py-3 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ $category->slug }}</td>
                            <td class="px-4 py-3">{{ $category->products_count }}</td>
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
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                No hay categorías registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($categories->hasPages())
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @endif
@endsection
