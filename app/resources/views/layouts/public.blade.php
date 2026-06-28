<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SnackConnect — Tus snacks favoritos, directo a tu WhatsApp. Catálogo de snacks artesanales con pedido directo.">
    <title>@yield('title', 'SnackConnect — Tus snacks favoritos')</title>

    {{-- Tipografía oficial: Instrument Sans (design-system.md §3) --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-base text-text-primary font-sans antialiased min-h-screen flex flex-col"
      data-cart-url="{{ route('cart.show') }}">

    {{-- ========================================== --}}
    {{-- Navbar Pública (ui-components.md §1.1)     --}}
    {{-- ========================================== --}}
    <nav class="sticky top-0 z-50 bg-bg-base border-b border-border-default" id="navbar-public">
        <div class="max-w-7xl mx-auto px-5 flex items-center justify-between h-14 md:h-16">
            {{-- Logo (branding.md §2.1) --}}
            <a href="{{ route('landing') }}" class="text-xl font-semibold text-text-primary tracking-tight hover:opacity-80 transition-opacity">
                SnackConnect
            </a>

            {{-- Links Desktop --}}
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('catalogo.index') }}"
                   class="text-sm font-medium text-text-primary hover:border-b hover:border-border-strong pb-0.5 transition-all">
                    Catálogo
                </a>
                <a href="{{ route('cart.show') }}"
                   class="relative sc-btn sc-btn-secondary text-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                    </svg>
                    Carrito
                    @if(($cartCount ?? 0) > 0)
                        <span class="sc-cart-badge" id="sc-cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
                @auth
                    @if(auth()->user()->isClient())
                        <a href="{{ route('client.dashboard') }}"
                           class="text-sm font-medium pb-0.5 transition-all {{ request()->routeIs('client.dashboard') ? 'text-brand-primary border-b-2 border-brand-primary' : 'text-text-primary hover:border-b hover:border-border-strong' }}">
                            Mi cuenta
                        </a>
                        <a href="{{ route('client.perfil.edit') }}"
                           class="text-sm font-medium pb-0.5 transition-all {{ request()->routeIs('client.perfil.*') ? 'text-brand-primary border-b-2 border-brand-primary' : 'text-text-primary hover:underline' }}">
                            Editar perfil
                        </a>
                        <a href="{{ route('client.pedidos.index') }}"
                           class="text-sm font-medium pb-0.5 transition-all {{ request()->routeIs('client.pedidos.*') ? 'text-brand-primary border-b-2 border-brand-primary' : 'text-text-primary hover:underline' }}">
                            Mis pedidos
                        </a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="sc-btn sc-btn-secondary text-sm">Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-text-secondary hover:text-text-primary">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="sc-btn sc-btn-secondary text-sm">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="sc-btn sc-btn-primary text-sm">Registrarse</a>
                @endauth
            </div>

            {{-- Hamburger Mobile --}}
            <button id="mobile-menu-btn" class="md:hidden p-2 text-text-primary" aria-label="Abrir menú">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-border-default bg-bg-base px-5 py-4 space-y-3">
            <a href="{{ route('catalogo.index') }}" class="block text-sm font-medium text-text-primary py-2">Catálogo</a>
            <a href="{{ route('cart.show') }}" class="block text-sm font-medium text-text-primary py-2">
                Carrito @if(($cartCount ?? 0) > 0)({{ $cartCount }})@endif
            </a>
            @auth
                @if(auth()->user()->isClient())
                    <a href="{{ route('client.dashboard') }}" class="block text-sm font-medium text-text-primary py-2">Mi cuenta</a>
                    <a href="{{ route('client.perfil.edit') }}" class="block text-sm font-medium text-text-primary py-2">Editar perfil</a>
                    <a href="{{ route('client.pedidos.index') }}" class="block text-sm font-medium text-text-primary py-2">Mis pedidos</a>
                @elseif(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block text-sm font-medium text-text-primary py-2">Panel admin</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block text-sm font-medium text-text-secondary py-2">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-sm font-medium text-text-secondary py-2">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="block text-sm font-medium text-brand-primary py-2">Registrarse</a>
            @endauth
        </div>
    </nav>

    @include('partials.flash-toast')
    @include('catalog.partials.product-panel')

    {{-- ========================================== --}}
    {{-- Contenido Principal                        --}}
    {{-- ========================================== --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ========================================== --}}
    {{-- Footer Público (branding.md §6.3)          --}}
    {{-- ========================================== --}}
    <footer class="bg-bg-surface border-t border-border-default" id="footer-public">
        <div class="max-w-7xl mx-auto px-5 py-8 text-center">
            <p class="text-[13px] text-text-secondary">
                SnackConnect &copy; {{ date('Y') }} &mdash; Todos los derechos reservados.
            </p>
            <p class="text-[13px] text-text-secondary mt-1">
                Hecho por Estudiantes Del ISTAE
            </p>
        </div>
    </footer>

    {{-- Mobile menu toggle --}}
    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
            const icon = this.querySelector('svg');
            if (menu.classList.contains('hidden')) {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>';
            } else {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>';
            }
        });
    </script>

    @if(session('cart_toast'))
    <script>
        setTimeout(function() {
            var toast = document.getElementById('sc-toast');
            if (toast) {
                toast.classList.add('sc-toast--hide');
                setTimeout(function() { toast.remove(); }, 300);
            }
        }, 5000);
    </script>
    @endif
</body>
</html>
