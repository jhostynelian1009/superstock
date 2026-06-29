<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SuperStock — Sistema interno de gestión de inventario. Control claro. Inventario confiable.">
    <title>@yield('title') - SuperStock</title>

    <!-- Google Fonts / Bunny Fonts CDN -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">

    <!-- CSS y JS de Laravel/Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SuperStock Design System Tokens -->
    <style>
        /* ===== Design System Tokens ===== */
        :root {
            --color-brand-primary: #1D4ED8;
            --color-brand-primary-hover: #1E40AF;
            --color-brand-secondary: #0F766E;
            --color-bg-base: #F8FAFC;
            --color-bg-surface: #FFFFFF;
            --color-bg-muted: #F1F5F9;
            --color-text-primary: #0F172A;
            --color-text-secondary: #475569;
            --color-text-inverse: #FFFFFF;
            --color-border-default: #CBD5E1;
            --color-success: #15803D;
            --color-warning: #D97706;
            --color-danger: #B91C1C;
            --color-info: #0369A1;
            --radius-sm: 4px;
            --radius-md: 6px;
            --radius-lg: 8px;
            --radius-full: 9999px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px -1px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.06);
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --color-brand-primary: #60A5FA;
                --color-brand-primary-hover: #93C5FD;
                --color-brand-secondary: #2DD4BF;
                --color-bg-base: #0F172A;
                --color-bg-surface: #1E293B;
                --color-bg-muted: #334155;
                --color-text-primary: #F8FAFC;
                --color-text-secondary: #CBD5E1;
                --color-text-inverse: #0F172A;
                --color-border-default: #475569;
                --color-success: #22C55E;
                --color-warning: #FBBF24;
                --color-danger: #EF4444;
                --color-info: #38BDF8;
            }
        }

        /* ===== Base ===== */
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: var(--color-bg-base);
            color: var(--color-text-primary);
        }

        /* ===== Brand ===== */
        .brand-text {
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 600;
            color: var(--color-text-primary);
        }

        /* ===== Form Controls ===== */
        .input-field {
            width: 100%;
            background-color: var(--color-bg-surface);
            border: 1px solid var(--color-border-default);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            font-size: 14px;
            font-family: inherit;
            height: 44px;
            color: var(--color-text-primary);
            transition: border-color 200ms ease, box-shadow 200ms ease;
        }
        .input-field::placeholder {
            color: var(--color-text-secondary);
            opacity: 0.7;
        }
        .input-field:hover {
            border-color: var(--color-brand-primary);
        }
        .input-field:focus {
            outline: none;
            border-color: var(--color-brand-primary);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.15);
        }
        .input-field.error {
            border-color: var(--color-danger);
        }
        .input-field.error:focus {
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.12);
        }
        .input-field:disabled {
            background-color: var(--color-bg-muted);
            opacity: 0.6;
            cursor: not-allowed;
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

        /* ===== Buttons ===== */
        .btn-primary {
            background-color: var(--color-brand-primary);
            color: var(--color-text-inverse);
            border: 1px solid var(--color-brand-primary);
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 15px;
            font-family: inherit;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: background-color 200ms ease, box-shadow 200ms ease, transform 100ms ease;
        }
        .btn-primary:hover {
            background-color: var(--color-brand-primary-hover);
            box-shadow: var(--shadow-md);
        }
        .btn-primary:active {
            transform: scale(0.98);
        }
        .btn-primary:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.3);
        }
        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background-color: var(--color-bg-surface);
            color: var(--color-text-primary);
            border: 1px solid var(--color-border-default);
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 14px;
            font-family: inherit;
            cursor: pointer;
            transition: background-color 200ms ease, border-color 200ms ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-secondary:hover {
            background-color: var(--color-bg-muted);
            border-color: var(--color-brand-primary);
        }

        /* ===== Login Layout ===== */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* -- Left Branding Panel -- */
        .login-brand-panel {
            display: none;
            width: 50%;
            background: linear-gradient(135deg, #1D4ED8 0%, #1E40AF 50%, #0F766E 100%);
            position: relative;
            overflow: hidden;
            padding: 48px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .login-brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 420px;
        }

        .login-brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        .login-brand-logo-icon {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 18px;
            color: #FFFFFF;
            font-family: 'Instrument Sans', sans-serif;
        }
        .login-brand-logo-text {
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 600;
            font-size: 28px;
            color: #FFFFFF;
            letter-spacing: -0.025em;
        }

        .login-brand-tagline {
            font-size: 32px;
            font-weight: 600;
            color: #FFFFFF;
            line-height: 1.25;
            letter-spacing: -0.025em;
            margin-bottom: 16px;
            font-family: 'Instrument Sans', sans-serif;
        }

        .login-brand-desc {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .login-brand-illustration {
            width: 100%;
            max-width: 320px;
            margin: 0 auto 32px;
            border-radius: var(--radius-lg);
            animation: float-illustration 6s ease-in-out infinite;
        }

        @keyframes float-illustration {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .login-brand-security {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
        }
        .login-brand-security svg {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
            opacity: 0.9;
        }

        /* Decorative blurred shapes */
        .login-brand-deco-1,
        .login-brand-deco-2,
        .login-brand-deco-3 {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 1;
        }
        .login-brand-deco-1 {
            width: 300px;
            height: 300px;
            background: rgba(15, 118, 110, 0.35);
            bottom: -80px;
            left: -60px;
        }
        .login-brand-deco-2 {
            width: 250px;
            height: 250px;
            background: rgba(96, 165, 250, 0.2);
            top: -50px;
            right: -50px;
        }
        .login-brand-deco-3 {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.08);
            top: 40%;
            left: 20%;
        }

        /* -- Right Form Panel -- */
        .login-form-panel {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 32px 24px;
            background-color: var(--color-bg-base);
        }
        .login-form-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .login-form-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 32px;
        }
        .login-form-logo-icon {
            width: 36px;
            height: 36px;
            background: var(--color-brand-primary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 15px;
            color: #FFFFFF;
            font-family: 'Instrument Sans', sans-serif;
        }

        .login-form-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-form-title {
            font-family: 'Instrument Sans', sans-serif;
            font-size: 24px;
            font-weight: 600;
            color: var(--color-text-primary);
            margin-bottom: 8px;
            letter-spacing: -0.025em;
        }
        .login-form-subtitle {
            font-size: 14px;
            color: var(--color-text-secondary);
        }

        /* Input wrapper with icon */
        .input-wrapper {
            position: relative;
        }
        .input-wrapper .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: var(--color-text-secondary);
            pointer-events: none;
            transition: color 200ms ease;
        }
        .input-wrapper .input-field {
            padding-left: 42px;
        }
        .input-wrapper:focus-within .input-icon {
            color: var(--color-brand-primary);
        }

        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: var(--color-text-secondary);
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 200ms ease;
        }
        .password-toggle:hover {
            color: var(--color-brand-primary);
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        .animate-delay-1 { animation-delay: 0.1s; opacity: 0; }
        .animate-delay-2 { animation-delay: 0.2s; opacity: 0; }
        .animate-delay-3 { animation-delay: 0.3s; opacity: 0; }
        .animate-delay-4 { animation-delay: 0.4s; opacity: 0; }
        .animate-delay-5 { animation-delay: 0.5s; opacity: 0; }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .animate-fade-in-up,
            .animate-fade-in {
                animation: none;
                opacity: 1;
            }
            .login-brand-illustration {
                animation: none;
            }
        }

        /* ===== Responsive ===== */
        @media (min-width: 768px) {
            .login-brand-panel {
                display: flex;
            }
            .login-form-panel {
                width: 50%;
                padding: 48px;
            }
            .login-form-logo {
                display: none;
            }
            .login-form-header {
                text-align: left;
            }
        }

        @media (min-width: 1024px) {
            .login-form-panel {
                padding: 48px 80px;
            }
            .login-brand-tagline {
                font-size: 36px;
            }
        }
    </style>
</head>
<body class="h-full">
    <div class="login-wrapper">
        <!-- Left: Branding Panel (hidden on mobile) -->
        <div class="login-brand-panel">
            <div class="login-brand-deco-1"></div>
            <div class="login-brand-deco-2"></div>
            <div class="login-brand-deco-3"></div>

            <div class="login-brand-content animate-fade-in">
                <div class="login-brand-logo">
                    <div class="login-brand-logo-icon">SS</div>
                    <span class="login-brand-logo-text">SuperStock</span>
                </div>

                <h2 class="login-brand-tagline">
                    Controla tu inventario, impulsa tu negocio.
                </h2>

                <p class="login-brand-desc">
                    Gestiona productos, proveedores y movimientos de inventario desde un solo lugar. Información precisa, decisiones confiables.
                </p>

                <img src="{{ asset('img/inventory-illustration.png') }}"
                     alt="Ilustración de gestión de inventario"
                     class="login-brand-illustration">

                <div class="login-brand-security">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                    <span>Acceso restringido a personal autorizado. Todas las operaciones quedan registradas.</span>
                </div>
            </div>
        </div>

        <!-- Right: Form Panel -->
        <div class="login-form-panel">
            <div class="login-form-container">
                <!-- Mobile Logo (visible only on mobile) -->
                <div class="login-form-logo animate-fade-in-up animate-delay-1">
                    <div class="login-form-logo-icon">SS</div>
                    <span class="brand-text" style="font-size: 22px;">SuperStock</span>
                </div>

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
