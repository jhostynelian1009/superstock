<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - SnackConnect</title>
    
    <!-- Google Fonts/Bunny Fonts CDN -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
    
    <!-- CSS y JS de Laravel/Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS Variables for Design System compliance -->
    <style>
        :root {
            --color-brand-primary: #F53003;
            --color-brand-secondary: #F8B803;
            --color-brand-rose: #F0ACB8;
            --color-brand-rose-light: #F3BEC7;
            --color-brand-dark-red: #1D0002;
            --color-bg-base: #FDFDFC;
            --color-bg-surface: #FFFFFF;
            --color-bg-muted: #fff2f2;
            --color-bg-subtle: #dbdbd7;
            --color-text-primary: #1b1b18;
            --color-text-secondary: #706f6c;
            --color-text-inverse: #FFFFFF;
            --color-border-default: #e3e3e0;
            --color-border-strong: rgba(25, 20, 0, 0.2);
            --color-success: #16a34a;
            --color-danger: #F53003;
            --radius-sm: 4px;
            --radius-lg: 8px;
            --radius-full: 9999px;
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --color-brand-primary: #FF4433;
                --color-bg-base: #0a0a0a;
                --color-bg-surface: #161615;
                --color-bg-muted: #1D0002;
                --color-bg-subtle: #3E3E3A;
                --color-text-primary: #EDEDEC;
                --color-text-secondary: #A1A09A;
                --color-text-inverse: #1C1C1A;
                --color-border-default: #3E3E3A;
                --color-border-strong: rgba(255, 250, 237, 0.18);
            }
        }
        
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: var(--color-bg-base);
            color: var(--color-text-primary);
        }

        .auth-card {
            background-color: var(--color-bg-surface);
            border-radius: var(--radius-lg);
            box-shadow: inset 0 0 0 1px var(--color-border-strong);
            padding: 24px;
        }

        .btn-primary {
            background-color: #1b1b18;
            color: #FFFFFF;
            border: 1px solid #000;
            border-radius: var(--radius-sm);
            font-weight: 500;
            transition: background-color 150ms ease-in-out;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #000000;
        }
        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-secondary {
            background-color: var(--color-bg-surface);
            color: var(--color-text-primary);
            border: 1px solid var(--color-border-default);
            border-radius: var(--radius-sm);
            font-weight: 500;
            transition: background-color 150ms ease-in-out, border-color 150ms ease-in-out;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-secondary:hover {
            background-color: var(--color-bg-muted);
            border-color: var(--color-border-strong);
        }

        .auth-back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 14px;
            font-weight: 500;
            color: var(--color-text-secondary);
            text-decoration: none;
            margin-bottom: 1.5rem;
            transition: color 150ms ease-in-out;
        }
        .auth-back-link:hover {
            color: var(--color-brand-primary);
        }

        .input-field {
            background-color: var(--color-bg-surface);
            border: 1px solid var(--color-border-default);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            font-size: 14px;
            height: 44px;
            transition: border-color 150ms ease-in-out, box-shadow 150ms ease-in-out;
        }
        .input-field:focus {
            outline: none;
            border-color: var(--color-brand-primary);
            box-shadow: 0 0 0 2px rgba(245, 48, 3, 0.20);
        }
        .input-field.error {
            border-color: var(--color-danger);
        }
        .input-field.error:focus {
            box-shadow: 0 0 0 2px rgba(245, 48, 3, 0.12);
        }
        .input-field:disabled {
            background-color: var(--color-bg-muted);
            opacity: 0.6;
        }

        .input-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--color-text-primary);
            margin-bottom: 8px;
            display: block;
        }
        .input-label .required {
            color: var(--color-danger);
            margin-left: 2px;
        }

        .error-message {
            font-size: 13px;
            color: var(--color-danger);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .brand-text {
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 600;
            color: var(--color-text-primary);
        }
    </style>
</head>
<body class="h-full">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Panel de Formulario (Izquierda/Abajo) -->
        <div class="w-full md:w-1/2 flex flex-col justify-center px-6 py-12 lg:px-16 xl:px-24 bg-[var(--color-bg-base)]">
            <div class="mx-auto w-full max-w-[448px]">
                <!-- Logo -->
                <div class="mb-8 text-center md:text-left flex items-center justify-center md:justify-start gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[var(--color-brand-primary)] flex items-center justify-center font-semibold text-white text-lg">
                        S
                    </div>
                    <span class="brand-text text-xl">SnackConnect</span>
                </div>

                <a href="{{ route('catalogo.index') }}" class="auth-back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Volver al catálogo
                </a>
                
                @yield('content')
            </div>
        </div>

        <!-- Panel Decorativo (Derecha/Arriba) -->
        <div class="hidden md:flex md:w-1/2 bg-[var(--color-bg-muted)] items-center justify-center p-12 relative overflow-hidden">
            <div class="max-w-md text-center z-10">
                <!-- Branding o Ilustración -->
                <h2 class="text-3xl lg:text-4xl font-semibold tracking-tight text-[var(--color-text-primary)] mb-4" style="font-family: 'Instrument Sans', sans-serif; letter-spacing: -0.025em;">
                    Tus snacks favoritos, directo a tu WhatsApp.
                </h2>
                <p class="text-lg text-[var(--color-text-secondary)]">
                    Administra tu catálogo de productos de forma rápida y sencilla.
                </p>
            </div>
            
            <!-- Elementos decorativos en rosa snack -->
            <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full bg-[var(--color-brand-rose)] opacity-20 filter blur-2xl"></div>
            <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-[var(--color-brand-rose-light)] opacity-30 filter blur-2xl"></div>
        </div>
    </div>
</body>
</html>
