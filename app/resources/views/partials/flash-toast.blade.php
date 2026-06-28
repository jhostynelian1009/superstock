@if(session('order_toast'))
    @php $orderToast = session('order_toast'); @endphp
    <div id="sc-toast" class="sc-toast sc-toast--{{ $orderToast['type'] ?? 'success' }}" role="alert" aria-live="polite">
        <div class="sc-toast-icon">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </div>
        <div class="sc-toast-body">
            <p class="sc-toast-title">{{ $orderToast['title'] ?? 'Pedido realizado con éxito' }}</p>
            <p class="sc-toast-message">{{ $orderToast['message'] ?? '' }}</p>
        </div>
        <a href="{{ route('catalogo.index') }}" class="sc-toast-action">Seguir comprando</a>
        <button type="button" class="sc-toast-close" onclick="document.getElementById('sc-toast')?.remove()" aria-label="Cerrar notificación">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

@if(session('cart_toast'))
    @php $toast = session('cart_toast'); @endphp
    <div id="sc-toast" class="sc-toast sc-toast--{{ $toast['type'] ?? 'success' }}" role="alert" aria-live="polite">
        <div class="sc-toast-icon">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </div>
        <div class="sc-toast-body">
            <p class="sc-toast-title">Producto añadido</p>
            <p class="sc-toast-message">{{ $toast['message'] }}</p>
        </div>
        <a href="{{ route('cart.show') }}" class="sc-toast-action">Ver carrito</a>
        <button type="button" class="sc-toast-close" onclick="document.getElementById('sc-toast')?.remove()" aria-label="Cerrar notificación">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

@if(session('error') && !session('cart_toast') && !session('order_toast'))
    <div id="sc-toast" class="sc-toast sc-toast--error" role="alert" aria-live="assertive">
        <div class="sc-toast-body">
            <p class="sc-toast-title">Atención</p>
            <p class="sc-toast-message">{{ session('error') }}</p>
        </div>
        <button type="button" class="sc-toast-close" onclick="document.getElementById('sc-toast')?.remove()" aria-label="Cerrar notificación">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif
