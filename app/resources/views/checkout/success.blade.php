@extends('layouts.public')

@section('title', 'Pedido realizado — SnackConnect')

@section('content')
<div class="max-w-lg mx-auto px-5 py-16 md:py-24">
    <div class="sc-card p-8 md:p-10 text-center">
        <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-[rgba(22,163,74,0.12)] flex items-center justify-center">
            <svg class="w-8 h-8 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </div>

        <div class="flex flex-wrap items-center justify-center gap-2 mb-4">
            <span class="admin-module-label admin-module-label--active">Pedido enviado</span>
            <span class="admin-module-label admin-module-label--info">WhatsApp</span>
        </div>

        <h1 class="text-2xl font-semibold text-text-primary">Pedido realizado con éxito</h1>
        @if(!empty($orderNumber))
            <p class="text-sm font-medium text-brand-primary mt-2">
                Número de pedido: {{ $orderNumber }}
            </p>
        @endif
        <p class="text-sm text-text-secondary mt-3 leading-relaxed">
            Tu carrito se vació correctamente. En unos segundos te llevaremos a WhatsApp para que completes el pedido con el negocio.
        </p>

        <p id="checkout-countdown" class="text-sm font-medium text-brand-primary mt-6">
            Redirigiendo a WhatsApp en <span id="checkout-countdown-seconds">3</span> segundos…
        </p>

        <div class="flex flex-col sm:flex-row gap-3 mt-8 justify-center">
            <a href="{{ $whatsappUrl }}"
               id="checkout-whatsapp-btn"
               class="sc-btn sc-btn-whatsapp justify-center"
               rel="noopener noreferrer">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.73-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436.002 9.858-4.42 9.862-9.864.002-2.638-1.023-5.117-2.884-6.979C16.59 1.899 14.116.877 11.48.875c-5.44 0-9.861 4.421-9.864 9.865-.001 1.772.464 3.502 1.346 5.027L1.935 21.8l6.19-1.625c-1.6.945-3.18 1.449-4.82 1.451z"/>
                </svg>
                Abrir WhatsApp ahora
            </a>
            <a href="{{ route('catalogo.index') }}" class="sc-btn sc-btn-secondary justify-center">
                Seguir comprando
            </a>
        </div>
    </div>
</div>

<script>
    (function () {
        var whatsappUrl = @json($whatsappUrl);
        var seconds = 3;
        var secondsEl = document.getElementById('checkout-countdown-seconds');
        var countdownEl = document.getElementById('checkout-countdown');
        var redirected = false;

        function goToWhatsApp() {
            if (redirected) return;
            redirected = true;
            window.location.href = whatsappUrl;
        }

        var timer = setInterval(function () {
            seconds -= 1;
            if (secondsEl) {
                secondsEl.textContent = String(Math.max(seconds, 0));
            }
            if (seconds <= 0) {
                clearInterval(timer);
                if (countdownEl) {
                    countdownEl.textContent = 'Abriendo WhatsApp…';
                }
                goToWhatsApp();
            }
        }, 1000);

        document.getElementById('checkout-whatsapp-btn')?.addEventListener('click', function () {
            clearInterval(timer);
            redirected = false;
        });
    })();
</script>
@endsection
