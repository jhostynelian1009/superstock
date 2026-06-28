{{--
    Product Card Component (ui-components.md §3.2)
    Reusable card used in both Landing and Catalog views.
    Props: $product (object with name, slug, description, price, image_path, status, category)
--}}
@php
    $imagePath = $product->image_path ?? $product->image ?? null;
    $productPayload = [
        'id' => $product->id,
        'name' => $product->name,
        'slug' => $product->slug,
        'description' => $product->description,
        'price' => (float) $product->price,
        'status' => $product->status ?? ($product->is_active ?? true ? 'active' : 'inactive'),
        'category' => $product->category->name,
        'image_path' => $imagePath,
        'image_url' => $imagePath ? asset('storage/' . $imagePath) : null,
    ];
@endphp
<article class="sc-card flex flex-col overflow-hidden transition-transform hover:-translate-y-0.5 {{ $product->status === 'inactive' ? 'opacity-60' : '' }}"
         id="product-card-{{ $product->slug }}"
         data-product='@json($productPayload)'>

    {{-- Image (aspect-ratio 1:1) — abre panel de detalle --}}
    <button type="button"
            data-product-panel-open
            class="block relative aspect-square overflow-hidden rounded-t-lg w-full text-left cursor-pointer border-0 p-0 bg-transparent">
        @if($imagePath)
            <img src="{{ asset('storage/' . $imagePath) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-105 pointer-events-none"
                 loading="lazy">
        @else
            <div class="w-full h-full bg-bg-muted flex flex-col items-center justify-center gap-2 pointer-events-none">
                <svg class="w-8 h-8 text-border-default" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
                </svg>
                <span class="text-[13px] text-text-secondary">Sin imagen</span>
            </div>
        @endif

        @if($product->status === 'inactive')
            <div class="absolute top-3 right-3 bg-bg-subtle text-text-secondary text-xs font-medium px-2.5 py-1 rounded-full pointer-events-none">
                Agotado
            </div>
        @endif
    </button>

    <div class="p-5 flex flex-col flex-1 gap-1.5">
        <div class="flex items-center justify-between gap-2">
            <span class="text-[13px] font-medium text-brand-rose">
                {{ $product->category->name }}
            </span>
            <span class="admin-module-label admin-module-label--{{ $product->status === 'active' ? 'active' : 'soon' }}">
                {{ $product->status === 'active' ? 'Disponible' : 'Agotado' }}
            </span>
        </div>

        <button type="button"
                data-product-panel-open
                class="text-lg font-semibold text-text-primary leading-snug hover:text-brand-primary transition-colors line-clamp-1 text-left border-0 bg-transparent p-0 cursor-pointer">
            {{ $product->name }}
        </button>

        <p class="text-sm text-text-secondary leading-relaxed line-clamp-2 mt-0.5">
            {{ $product->description }}
        </p>

        <div class="flex-1 min-h-2"></div>

        <p class="text-lg font-semibold text-brand-secondary mt-2">
            ${{ number_format($product->price, 2) }}
        </p>

        <button type="button"
                data-product-panel-open
                class="sc-btn sc-btn-secondary w-full mt-1 text-sm">
            Ver detalle
        </button>

        @if($product->status === 'active')
            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-2 js-cart-add-form">
                @csrf
                <button type="submit" class="sc-btn sc-btn-primary w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                    </svg>
                    Agregar al Carrito
                </button>
            </form>
        @else
            <button type="button" class="sc-btn sc-btn-secondary w-full mt-2 cursor-not-allowed opacity-50" disabled>
                No Disponible
            </button>
        @endif
    </div>
</article>
