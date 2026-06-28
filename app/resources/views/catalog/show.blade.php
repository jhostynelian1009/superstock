{{-- Vista de Detalle de Producto — DEV-FRONT (Genesis-Valencia) --}}
@extends('layouts.public')

@section('title', $product->name . ' — SnackConnect')

@section('content')
<div class="max-w-7xl mx-auto px-5 py-6 md:py-10">
    
    {{-- Breadcrumb (ui-components.md §1.2) --}}
    <nav class="flex items-center gap-2 text-[13px] text-text-secondary mb-6 md:mb-8" aria-label="Breadcrumb">
        <a href="{{ route('landing') }}" class="hover:text-text-primary transition-colors">Inicio</a>
        <span class="text-border-default">/</span>
        <a href="{{ route('catalogo.index') }}" class="hover:text-text-primary transition-colors">Catálogo</a>
        <span class="text-border-default">/</span>
        <a href="{{ route('catalogo.index', ['category' => $product->category->slug]) }}" class="hover:text-text-primary transition-colors">
            {{ $product->category->name }}
        </a>
        <span class="text-border-default">/</span>
        <span class="text-text-primary font-medium truncate" aria-current="page">{{ $product->name }}</span>
    </nav>

    {{-- Contenido Principal Detalle --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12" id="product-detail-container">
        
        {{-- Columna Izquierda: Imagen --}}
        <div class="aspect-square relative overflow-hidden bg-bg-surface rounded-lg shadow-inset">
            @if($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover rounded-lg"
                     id="product-main-image">
            @else
                {{-- Placeholder (branding.md §5.2) --}}
                <div class="w-full h-full bg-bg-muted flex flex-col items-center justify-center gap-3">
                    <svg class="w-16 h-16 text-border-default" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
                    </svg>
                    <span class="text-sm text-text-secondary">Imagen no disponible</span>
                </div>
            @endif

            @if($product->status === 'inactive')
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center backdrop-blur-xs">
                    <span class="bg-bg-surface text-text-primary px-5 py-2 rounded-full font-semibold shadow-elevated">
                        AGOTADO
                    </span>
                </div>
            @endif
        </div>

        {{-- Columna Derecha: Información --}}
        <div class="flex flex-col justify-start">
            {{-- Categoría (chip) --}}
            <div class="mb-3">
                <a href="{{ route('catalogo.index', ['category' => $product->category->slug]) }}" 
                   class="inline-block text-xs font-semibold text-brand-primary bg-bg-muted px-3 py-1 rounded-full hover:bg-brand-rose-light/20 transition-colors">
                    {{ $product->category->name }}
                </a>
            </div>

            {{-- Nombre (h1) --}}
            <h1 class="text-3xl font-semibold tracking-tight text-text-primary leading-tight">
                {{ $product->name }}
            </h1>

            {{-- Precio destacado --}}
            <div class="mt-4 flex items-center gap-3">
                <span class="text-2xl font-semibold text-brand-secondary">
                    ${{ number_format($product->price, 2) }}
                </span>
                @if($product->status === 'active')
                    <span class="inline-flex items-center gap-1 text-xs font-medium text-success bg-green-500/10 px-2 py-0.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                        Disponible
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-xs font-medium text-text-secondary bg-bg-subtle/20 px-2 py-0.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-text-secondary"></span>
                        No disponible
                    </span>
                @endif
            </div>

            {{-- Separador --}}
            <div class="h-px bg-border-default my-6"></div>

            {{-- Descripción --}}
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-text-primary uppercase tracking-wider">Descripción</h3>
                <p class="text-base text-text-secondary leading-relaxed">
                    {{ $product->description }}
                </p>
            </div>

            {{-- Acciones --}}
            <div class="mt-8 space-y-3">
                @if($product->status === 'active')
                    {{-- Pedir por WhatsApp: agrega al carrito y redirige al checkout --}}
                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf
                        <input type="hidden" name="whatsapp_redirect" value="1">
                        <button type="submit" class="sc-btn sc-btn-whatsapp sc-btn-lg w-full justify-center" id="whatsapp-order-btn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                            </svg>
                            Pedir por WhatsApp
                        </button>
                    </form>
                    {{-- Botón Secundario Carrito --}}
                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf
                        <button type="submit" class="sc-btn sc-btn-secondary w-full justify-center" id="add-to-cart-detail-btn">
                            Agregar al Carrito
                        </button>
                    </form>
                @else
                    <button type="button" class="sc-btn sc-btn-secondary w-full justify-center cursor-not-allowed opacity-50" disabled>
                        Producto Agotado
                    </button>
                @endif
            </div>

            {{-- Información de Envíos/Método --}}
            <div class="mt-6 flex gap-3 p-4 bg-bg-muted rounded-md border border-border-default">
                <svg class="w-5 h-5 text-brand-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-xs text-text-secondary leading-relaxed">
                    <span class="font-semibold text-text-primary block">Horario de Atención</span>
                    Los pedidos se atienden de Lunes a Domingo de 08:00 AM a 10:00 PM. Entrega local rápida.
                </div>
            </div>

        </div>
    </div>

    {{-- ========================================== --}}
    {{-- Productos Relacionados                     --}}
    {{-- ========================================== --}}
    @if($relatedProducts->isNotEmpty())
        <div class="h-px bg-border-default my-16"></div>

        <section id="related-products-section">
            <h2 class="text-2xl font-semibold text-text-primary mb-8">Productos Relacionados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($relatedProducts as $related)
                    @include('catalog._product-card', ['product' => $related])
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection
