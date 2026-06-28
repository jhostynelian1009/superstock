{{-- Landing Page Pública — DEV-FRONT (Genesis-Valencia) --}}
@extends('layouts.public')

@section('title', 'SnackConnect — Tus snacks favoritos, directo a tu WhatsApp')

@section('content')

    {{-- ========================================== --}}
    {{-- Hero Section (design-system.md §10 Landing) --}}
    {{-- ========================================== --}}
    <section class="bg-bg-muted relative overflow-hidden" id="hero-section">
        {{-- Decorative circles --}}
        <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-brand-rose/20 blur-3xl"></div>
        <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-brand-secondary/15 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-5 py-20 md:py-28 relative z-10">
            <div class="max-w-2xl">
                <span class="inline-block text-xs font-medium text-brand-rose bg-bg-surface px-3 py-1 rounded-full mb-6 shadow-xs">
                    🍿 Snacks artesanales
                </span>
                <h1 class="text-[2.5rem] md:text-[3rem] font-semibold leading-[1.1] text-text-primary tracking-tight">
                    Tus snacks favoritos,
                    <span class="text-brand-primary">directo a tu WhatsApp.</span>
                </h1>
                <p class="mt-5 text-base md:text-lg text-text-secondary max-w-lg leading-relaxed">
                    Explora nuestro catálogo de snacks artesanales y haz tu pedido con un solo clic. Sin intermediarios, sin complicaciones.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('catalogo.index') }}" class="sc-btn sc-btn-accent sc-btn-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/>
                        </svg>
                        Ver Catálogo
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- Categorías Destacadas                      --}}
    {{-- ========================================== --}}
    <section class="max-w-7xl mx-auto px-5 py-16" id="categories-section">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-semibold text-text-primary">Nuestras Categorías</h2>
            <p class="mt-2 text-sm text-text-secondary">Encuentra exactamente lo que buscas</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('catalogo.index', ['category' => $category->slug]) }}"
                   class="sc-card group p-6 text-center transition-all hover:-translate-y-0.5" id="category-card-{{ $category->slug }}">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-brand-rose-light/50 flex items-center justify-center">
                        @if($category->slug === 'dulces')
                            <span class="text-2xl">🧁</span>
                        @elseif($category->slug === 'salados')
                            <span class="text-2xl">🥨</span>
                        @elseif($category->slug === 'bebidas')
                            <span class="text-2xl">🥤</span>
                        @else
                            <span class="text-2xl">🥗</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-medium text-text-primary group-hover:text-brand-primary transition-colors">
                        {{ $category->name }}
                    </h3>
                    <p class="text-xs text-text-secondary mt-1">{{ $category->description }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- Productos Destacados                       --}}
    {{-- ========================================== --}}
    <section class="bg-bg-surface border-t border-border-default" id="featured-products-section">
        <div class="max-w-7xl mx-auto px-5 py-16">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-2xl font-semibold text-text-primary">Productos Destacados</h2>
                    <p class="mt-2 text-sm text-text-secondary">Los favoritos de nuestros clientes</p>
                </div>
                <a href="{{ route('catalogo.index') }}" class="hidden sm:inline-flex sc-btn sc-btn-secondary text-sm">
                    Ver todos
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="square" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($featuredProducts as $product)
                    @include('catalog._product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-8 text-center sm:hidden">
                <a href="{{ route('catalogo.index') }}" class="sc-btn sc-btn-accent">Ver todo el catálogo</a>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- CTA WhatsApp (visual only)                 --}}
    {{-- ========================================== --}}
    <section class="bg-bg-muted" id="cta-whatsapp-section">
        <div class="max-w-7xl mx-auto px-5 py-16 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-brand-whatsapp/10 flex items-center justify-center">
                    <svg class="w-8 h-8 text-brand-whatsapp" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-text-primary">Pedido directo por WhatsApp</h2>
                <p class="mt-3 text-sm text-text-secondary leading-relaxed">
                    Elige tus snacks favoritos y envía tu pedido directamente por WhatsApp. Sin registros, sin pasarelas de pago. Simple y rápido.
                </p>
                <a href="{{ route('catalogo.index') }}" class="sc-btn sc-btn-whatsapp sc-btn-lg mt-6">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                    </svg>
                    Explorar Catálogo
                </a>
            </div>
        </div>
    </section>

@endsection
