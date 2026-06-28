{{-- Vista de Catálogo Público — DEV-FRONT (Genesis-Valencia) --}}
@extends('layouts.public')

@section('title', 'Catálogo de Snacks — SnackConnect')

@section('content')
<div class="max-w-7xl mx-auto px-5 py-8 md:py-12">
    
    {{-- Header del Catálogo --}}
    <div class="text-center md:text-left mb-8">
        <h1 class="text-3xl font-semibold tracking-tight text-text-primary">Nuestro Catálogo</h1>
        <p class="text-sm text-text-secondary mt-2">Explora y elige tus snacks favoritos para pedir por WhatsApp</p>
    </div>

    {{-- Buscador y Filtros --}}
    <div class="mb-10 space-y-6">
        {{-- Buscador (ui-components.md §5) --}}
        <form action="{{ route('catalogo.index') }}" method="GET" class="max-w-md">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="relative">
                <input type="text" 
                       name="search" 
                       value="{{ $searchTerm }}" 
                       placeholder="Ej: Muffin de Chocolate..." 
                       class="w-full bg-bg-surface border border-border-default rounded-[4px] px-4 py-3 pr-10 text-sm focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/20 h-11 transition-all"
                       id="catalog-search-input">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary hover:text-brand-primary" aria-label="Buscar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z"/>
                    </svg>
                </button>
            </div>
        </form>

        {{-- Chips de Categorías (ui-components.md §3.4) --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 sc-chips-scroll -mx-5 px-5 md:mx-0 md:px-0">
            {{-- Opción "Todas" --}}
            <a href="{{ route('catalogo.index', array_merge(request()->except('category', 'page'))) }}" 
               class="sc-chip {{ !$currentCategory ? 'active' : '' }}"
               id="category-chip-all">
                Todas
            </a>

            @foreach($categories as $category)
                <a href="{{ route('catalogo.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}" 
                   class="sc-chip {{ $currentCategory === $category->slug ? 'active' : '' }}"
                   id="category-chip-{{ $category->slug }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Estado con Resultados de Búsqueda --}}
    @if($searchTerm || $currentCategory)
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6 bg-bg-muted p-4 rounded-lg" id="search-filter-status">
            <div class="text-sm text-text-secondary">
                Mostrando resultados para: 
                @if($currentCategory)
                    <span class="font-medium text-text-primary">Categoría: "{{ $categories->firstWhere('slug', $currentCategory)->name ?? $currentCategory }}"</span>
                @endif
                @if($searchTerm)
                    @if($currentCategory) y @endif
                    <span class="font-medium text-text-primary">Búsqueda: "{{ $searchTerm }}"</span>
                @endif
            </div>
            <a href="{{ route('catalogo.index') }}" class="text-xs font-medium text-brand-primary hover:underline flex items-center gap-1">
                Limpiar filtros
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </a>
        </div>
    @endif

    {{-- Grid de Productos (design-system.md §10 - 1 col mobile, 2 sm, 3 lg, 4 xl) --}}
    @if($products->isEmpty())
        {{-- Empty State (ui-components.md §7 + design-system.md §10) --}}
        <div class="text-center py-16 bg-bg-surface rounded-lg border border-border-default shadow-xs" id="catalog-empty-state">
            <div class="w-16 h-16 mx-auto mb-4 bg-bg-muted rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-text-primary">No se encontraron productos</h3>
            <p class="text-sm text-text-secondary mt-2 max-w-xs mx-auto">
                No encontramos snacks que coincidan con tu búsqueda. Intenta con otros términos o limpia los filtros.
            </p>
            <div class="mt-6">
                <a href="{{ route('catalogo.index') }}" class="sc-btn sc-btn-primary">Ver todos los productos</a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="products-grid">
            @foreach($products as $product)
                @include('catalog._product-card', ['product' => $product])
            @endforeach
        </div>

        {{-- Paginación (ui-components.md §10) --}}
        @if($products->hasPages())
            <div class="mt-12 flex justify-center" id="catalog-pagination">
                <nav class="sc-pagination" role="navigation" aria-label="Navegación de páginas">
                    {{-- Anterior --}}
                    @if($products->onFirstPage())
                        <span class="disabled" aria-disabled="true" aria-label="Anterior">
                            <span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" rel="prev" aria-label="Anterior">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Páginas --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span class="active" aria-current="page">
                                <span>{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Siguiente --}}
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" rel="next" aria-label="Siguiente">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                            </svg>
                        </a>
                    @else
                        <span class="disabled" aria-disabled="true" aria-label="Siguiente">
                            <span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                </svg>
                            </span>
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    @endif
</div>

@if($openProductSlug ?? null)
<script>window.__SC_OPEN_PRODUCT__ = @json($openProductSlug);</script>
@endif
@endsection
