<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Carrito de Compras - SnackConnect</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback styles are defined below -->
    @endif
    
    <!-- Inline fallback/extension styles aligned with design-system.md -->
    <style>
        :root {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            --brand-primary: #F53003;
            --brand-primary-hover: #D42802;
            --whatsapp-green: #25D366;
            --whatsapp-green-hover: #128C7E;
        }
        body {
            font-family: var(--font-sans);
        }
        .whatsapp-btn {
            background-color: var(--whatsapp-green);
            transition: all 0.2s ease-in-out;
        }
        .whatsapp-btn:hover {
            background-color: var(--whatsapp-green-hover);
            transform: translateY(-1px);
        }
        .primary-btn {
            background-color: var(--brand-primary);
            transition: all 0.2s ease-in-out;
        }
        .primary-btn:hover {
            background-color: var(--brand-primary-hover);
        }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex flex-col transition-colors duration-200">
    
    <!-- Navigation Bar -->
    <header class="border-b border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <!-- SnackConnect Logo / Identity -->
                <a href="/" class="flex items-center gap-2">
                    <span class="h-8 w-8 rounded-full bg-[#f53003] flex items-center justify-center text-white font-bold text-lg shadow-sm">S</span>
                    <span class="font-bold text-xl tracking-tight text-[#1b1b18] dark:text-white">Snack<span class="text-[#f53003]">Connect</span></span>
                </a>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('catalogo.index') }}" class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white transition-colors">
                    Catálogo
                </a>
                @auth
                    @if(auth()->user()->isClient())
                        <a href="{{ route('client.dashboard') }}" class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white transition-colors">
                            Mi cuenta
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white transition-colors cursor-pointer">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-white transition-colors">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-[#f53003] dark:text-[#FF4433] hover:underline">
                        Registrarse
                    </a>
                @endauth
                <span class="h-4 w-px bg-[#e3e3e0] dark:border-[#3E3E3A]"></span>
                <span class="relative inline-flex items-center bg-[#fff2f2] dark:bg-[#1D0002] text-[#f53003] dark:text-[#FF4433] px-3 py-1 rounded-full text-xs font-semibold">
                    Checkout WhatsApp
                </span>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Alerts for feedback -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl border border-green-200 bg-green-50 dark:bg-emerald-950/20 dark:border-emerald-800 text-green-800 dark:text-emerald-400 text-sm flex items-center gap-2 animate-pulse">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl border border-red-200 bg-[#fff2f2] dark:bg-rose-950/20 dark:border-rose-950 text-[#f53003] dark:text-[#FF4433] text-sm flex items-center gap-2">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: Cart Items List -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-[#161615] rounded-2xl border border-[#e3e3e0] dark:border-[#3E3E3A] p-6 shadow-sm">
                    <div class="flex items-center justify-between border-b border-[#e3e3e0] dark:border-[#3E3E3A] pb-4 mb-4">
                        <h2 class="text-xl font-bold text-[#1b1b18] dark:text-white flex items-center gap-2">
                            <span>Mi Carrito</span>
                            <span class="text-xs px-2.5 py-0.5 rounded-full bg-[#1b1b18]/10 dark:bg-white/10 text-[#706f6c] dark:text-[#A1A09A]">
                                {{ count($cart) }} {{ count($cart) === 1 ? 'item' : 'items' }}
                            </span>
                        </h2>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('catalogo.index') }}"
                               class="text-sm font-semibold text-[#1b1b18] dark:text-white border border-[#e3e3e0] dark:border-[#3E3E3A] px-3 py-1.5 rounded-full hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors inline-flex items-center gap-1.5">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Seguir agregando
                            </a>
                        @if(count($cart) > 0)
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-[#f53003] hover:underline cursor-pointer">
                                    Vaciar Carrito
                                </button>
                            </form>
                        @endif
                        </div>
                    </div>

                    @if(count($cart) > 0)
                        <div class="divide-y divide-[#e3e3e0] dark:divide-[#3E3E3A]">
                            @foreach($cart as $id => $item)
                                @php
                                    $cartImageUrl = ! empty($item['image']) ? asset('storage/'.$item['image']) : null;
                                @endphp
                                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        @if ($cartImageUrl)
                                            <span class="sc-cart-thumb" title="{{ $item['name'] }}">
                                                <img src="{{ $cartImageUrl }}" alt="{{ $item['name'] }}" loading="lazy">
                                            </span>
                                        @else
                                            <span class="sc-cart-thumb sc-cart-thumb--placeholder" title="{{ $item['name'] }}">
                                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
                                                </svg>
                                            </span>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-base text-[#1b1b18] dark:text-white">{{ $item['name'] }}</h3>
                                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">${{ number_format($item['price'], 2) }} c/u</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between sm:justify-end gap-6">
                                        <!-- Subtotal item -->
                                        <span class="font-bold text-base min-w-[70px] text-right">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </span>
                                        
                                        <!-- Quantity controls -->
                                        <div class="flex items-center gap-1 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-full p-1 bg-gray-50 dark:bg-[#0a0a0a]">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="h-7 w-7 rounded-full flex items-center justify-center text-sm font-bold text-[#706f6c] hover:bg-[#e3e3e0] dark:hover:bg-[#3E3E3A] cursor-pointer">&minus;</button>
                                            </form>
                                            <span class="px-2 font-semibold text-sm">{{ $item['quantity'] }}</span>
                                            <form action="{{ route('cart.add', $id) }}" method="POST" class="js-cart-add-form">
                                                @csrf
                                                <button type="submit" class="h-7 w-7 rounded-full flex items-center justify-center text-sm font-bold text-[#706f6c] hover:bg-[#e3e3e0] dark:hover:bg-[#3E3E3A] cursor-pointer">&plus;</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="py-12 text-center">
                            <div class="h-16 w-16 bg-[#fff2f2] dark:bg-[#1D0002] text-[#f53003] dark:text-[#FF4433] rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-1">El carrito está vacío</h3>
                            <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm mb-6 max-w-md mx-auto">Explora el catálogo y agrega tus snacks favoritos al carrito.</p>
                            <a href="{{ route('catalogo.index') }}"
                               class="primary-btn inline-flex items-center gap-2 text-white text-sm font-semibold px-5 py-2.5 rounded-full">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                                Ir al catálogo
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Mock Catalog Section (For DX testing) -->
                <div class="bg-white dark:bg-[#161615] rounded-2xl border border-[#e3e3e0] dark:border-[#3E3E3A] p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-[#1b1b18] dark:text-white mb-2">Agregar más snacks</h2>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-6">Explora el catálogo y añade más productos a tu pedido.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($products as $product)
                            @php
                                $productImageUrl = ! empty($product['image']) ? asset('storage/'.$product['image']) : null;
                            @endphp
                            <div class="border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-xl p-4 flex gap-4 hover:shadow-md transition-all">
                                @if ($productImageUrl)
                                    <span class="sc-cart-thumb sc-cart-thumb--sm shrink-0" title="{{ $product['name'] }}">
                                        <img src="{{ $productImageUrl }}" alt="{{ $product['name'] }}" loading="lazy">
                                    </span>
                                @else
                                    <span class="sc-cart-thumb sc-cart-thumb--sm sc-cart-thumb--placeholder shrink-0" title="{{ $product['name'] }}">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
                                        </svg>
                                    </span>
                                @endif
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <h4 class="font-bold text-sm text-[#1b1b18] dark:text-white">{{ $product['name'] }}</h4>
                                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] line-clamp-2 mt-0.5">{{ $product['description'] }}</p>
                                    </div>
                                    <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100 dark:border-zinc-800">
                                        <span class="font-extrabold text-sm text-[#f53003] dark:text-[#FF4433]">${{ number_format($product['price'], 2) }}</span>
                                        <form action="{{ route('cart.add', $product['id']) }}" method="POST" class="js-cart-add-form">
                                            @csrf
                                            <button type="submit" class="primary-btn text-white text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1 cursor-pointer">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Añadir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Right Side: Order Summary & Checkout Form -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-[#161615] rounded-2xl border border-[#e3e3e0] dark:border-[#3E3E3A] p-6 shadow-sm sticky top-24">
                    <h3 class="text-lg font-bold text-[#1b1b18] dark:text-white mb-4">Resumen del Pedido</h3>

                    @if(count($cart) > 0)
                        <div class="sc-cart-summary-thumbs">
                            @foreach($cart as $item)
                                @php
                                    $summaryImageUrl = ! empty($item['image']) ? asset('storage/'.$item['image']) : null;
                                @endphp
                                <div class="sc-cart-summary-thumb-item" title="{{ $item['name'] }} × {{ $item['quantity'] }}">
                                    @if ($summaryImageUrl)
                                        <span class="sc-cart-thumb sc-cart-thumb--sm">
                                            <img src="{{ $summaryImageUrl }}" alt="{{ $item['name'] }}" loading="lazy">
                                        </span>
                                    @else
                                        <span class="sc-cart-thumb sc-cart-thumb--sm sc-cart-thumb--placeholder">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
                                            </svg>
                                        </span>
                                    @endif
                                    <span class="sc-cart-summary-thumb-qty">{{ $item['quantity'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#706f6c] dark:text-[#A1A09A]">Subtotal</span>
                            <span class="font-medium">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-[#706f6c] dark:text-[#A1A09A]">Costo de Envío</span>
                            <span class="text-green-600 dark:text-emerald-400 font-medium">Gratis / WhatsApp Direct</span>
                        </div>
                        <hr class="border-[#e3e3e0] dark:border-[#3E3E3A]" />
                        <div class="flex justify-between items-baseline pt-2">
                            <span class="text-base font-bold">Total Estimado</span>
                            <span class="text-2xl font-black text-[#f53003] dark:text-[#FF4433]">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    @if(count($cart) > 0)
                        @auth
                            @if(auth()->user()->isClient())
                        @php
                            $client = auth()->user();
                            $savedDelivery = old('delivery_type', $client->default_delivery_type ?? 'llevar');
                        @endphp
                        <!-- Form to process checkout -->
                        <div class="mb-4 p-4 rounded-xl bg-[#fff2f2] dark:bg-[#1D0002] border border-[#e3e3e0] dark:border-[#3E3E3A]">
                            <p class="text-xs font-semibold text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider mb-1">Comprando como</p>
                            <p class="text-sm font-semibold text-[#1b1b18] dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">{{ auth()->user()->email }} · {{ auth()->user()->phone }}</p>
                        </div>

                        <form action="{{ route('checkout.whatsapp') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-semibold text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider mb-2">
                                    Método de Entrega *
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-xl p-3 flex flex-col items-center gap-1 cursor-pointer hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors">
                                        <input type="radio" name="delivery_type" value="llevar" class="accent-[#f53003]" {{ $savedDelivery === 'llevar' ? 'checked' : '' }} />
                                        <span class="text-xs font-medium mt-1">Para Llevar</span>
                                    </label>
                                    <label class="border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-xl p-3 flex flex-col items-center gap-1 cursor-pointer hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors">
                                        <input type="radio" name="delivery_type" value="local" class="accent-[#f53003]" {{ $savedDelivery === 'local' ? 'checked' : '' }} />
                                        <span class="text-xs font-medium mt-1">Consumo Local</span>
                                    </label>
                                </div>
                                @error('delivery_type')
                                    <p class="text-xs text-[#f53003] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="delivery-address-fields" class="space-y-4 {{ $savedDelivery === 'local' ? 'hidden' : '' }}">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-xs font-semibold text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">
                                        Dirección de entrega *
                                    </p>
                                    <a href="{{ route('client.perfil.edit') }}" class="text-xs font-medium text-[#f53003] dark:text-[#FF4433] hover:underline shrink-0">
                                        Editar en perfil
                                    </a>
                                </div>

                                @if(!$client->hasSavedDeliveryAddress() && $savedDelivery === 'llevar')
                                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                        Guarda tu dirección en
                                        <a href="{{ route('client.perfil.edit') }}" class="text-[#f53003] dark:text-[#FF4433] font-medium hover:underline">Editar perfil</a>
                                        para no escribirla en cada pedido.
                                    </p>
                                @endif

                                <div>
                                    <label for="address_neighborhood" class="block text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] mb-1.5">
                                        Barrio
                                    </label>
                                    <input type="text" id="address_neighborhood" name="address_neighborhood" value="{{ old('address_neighborhood', $client->address_neighborhood) }}" placeholder="Ej. La Floresta"
                                           class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-transparent focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm" />
                                    @error('address_neighborhood')
                                        <p class="text-xs text-[#f53003] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="address_main_street" class="block text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] mb-1.5">
                                        Calle principal
                                    </label>
                                    <input type="text" id="address_main_street" name="address_main_street" value="{{ old('address_main_street', $client->address_main_street) }}" placeholder="Ej. Av. de los Shyris"
                                           class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-transparent focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm" />
                                    @error('address_main_street')
                                        <p class="text-xs text-[#f53003] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="address_secondary_street" class="block text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] mb-1.5">
                                        Calle secundaria
                                    </label>
                                    <input type="text" id="address_secondary_street" name="address_secondary_street" value="{{ old('address_secondary_street', $client->address_secondary_street) }}" placeholder="Ej. Calle El Universo"
                                           class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-transparent focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm" />
                                    @error('address_secondary_street')
                                        <p class="text-xs text-[#f53003] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="address_reference" class="block text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] mb-1.5">
                                        Referencia o número de casa
                                    </label>
                                    <input type="text" id="address_reference" name="address_reference" value="{{ old('address_reference', $client->address_reference) }}" placeholder="Ej. Casa blanca, portón negro / Nº 24-15"
                                           class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-transparent focus:outline-none focus:ring-2 focus:ring-[#f53003] text-sm" />
                                    @error('address_reference')
                                        <p class="text-xs text-[#f53003] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Checkout via WhatsApp button -->
                            <button type="submit" class="w-full whatsapp-btn text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 cursor-pointer shadow-md mt-6">
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.73-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436.002 9.858-4.42 9.862-9.864.002-2.638-1.023-5.117-2.884-6.979C16.59 1.899 14.116.877 11.48.875c-5.44 0-9.861 4.421-9.864 9.865-.001 1.772.464 3.502 1.346 5.027L1.935 21.8l6.19-1.625c-1.6.945-3.18 1.449-4.82 1.451z"/>
                                </svg>
                                Comprar por WhatsApp
                            </button>
                        </form>

                        <a href="{{ route('catalogo.index') }}"
                           class="w-full mt-3 border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-white font-semibold py-3 px-4 rounded-xl flex items-center justify-center gap-2 hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Seguir agregando productos
                        </a>
                            @else
                        <div class="p-4 rounded-xl border border-amber-200 bg-amber-50 dark:bg-amber-950/20 dark:border-amber-800 text-sm text-amber-900 dark:text-amber-200">
                            <p class="font-semibold mb-1">Sesión de administrador</p>
                            <p>Para comprar debes iniciar sesión como <strong>cliente</strong> o crear una cuenta de cliente.</p>
                            <div class="flex flex-col gap-2 mt-4">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-white font-semibold py-3 px-4 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors cursor-pointer">
                                        Cerrar sesión de admin
                                    </button>
                                </form>
                            </div>
                        </div>
                            @endif
                        @else
                        <div class="p-4 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-[#fff2f2] dark:bg-[#1D0002] text-sm">
                            <p class="font-semibold text-[#1b1b18] dark:text-white mb-1">Inicia sesión para comprar</p>
                            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">Solo los clientes registrados pueden confirmar un pedido por WhatsApp.</p>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('login') }}" class="w-full primary-btn text-white font-bold py-3 px-4 rounded-xl flex items-center justify-center">
                                    Iniciar sesión
                                </a>
                                <a href="{{ route('register') }}" class="w-full border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-white font-semibold py-3 px-4 rounded-xl flex items-center justify-center hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition-colors">
                                    Crear cuenta de cliente
                                </a>
                            </div>
                        </div>
                        @endauth
                    @else
                        <!-- Disabled form representation when empty -->
                        <div class="space-y-4">
                            <div class="opacity-50">
                                <label class="block text-xs font-semibold text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider mb-2">Nombre Completo *</label>
                                <input type="text" disabled class="w-full px-4 py-3 rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] bg-transparent text-sm" />
                            </div>
                            <div class="opacity-50">
                                <label class="block text-xs font-semibold text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider mb-2">Método de Entrega *</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-xl p-3 flex flex-col items-center gap-1"><span class="text-xs font-medium">Para Llevar</span></div>
                                    <div class="border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-xl p-3 flex flex-col items-center gap-1"><span class="text-xs font-medium">Consumo Local</span></div>
                                </div>
                            </div>
                            <button disabled class="w-full bg-[#1b1b18]/10 dark:bg-white/10 text-[#706f6c] dark:text-[#A1A09A] font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed mt-6">
                                Carrito Vacío
                            </button>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
            <p>&copy; {{ date('Y') }} SnackConnect. Todos los derechos reservados. Hecho por Estudiantes Del ISTAE.</p>
        </div>
    </footer>

    <script>
        (function () {
            const addressFields = document.getElementById('delivery-address-fields');
            const deliveryRadios = document.querySelectorAll('input[name="delivery_type"]');
            if (!addressFields || !deliveryRadios.length) return;

            function toggleAddressFields() {
                const isDelivery = document.querySelector('input[name="delivery_type"]:checked')?.value === 'llevar';
                addressFields.classList.toggle('hidden', !isDelivery);
                addressFields.querySelectorAll('input').forEach(function (input) {
                    input.toggleAttribute('required', isDelivery);
                });
            }

            deliveryRadios.forEach(function (radio) {
                radio.addEventListener('change', toggleAddressFields);
            });

            toggleAddressFields();
        })();
    </script>

</body>
</html>
