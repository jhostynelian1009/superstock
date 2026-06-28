@extends('layouts.client')

@section('title', 'Editar perfil — SnackConnect')
@section('page_title', 'Editar perfil')
@section('page_subtitle', 'Actualiza tus datos y tu ubicación de entrega')

@section('client_content')
<form action="{{ route('client.perfil.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="sc-card p-6">
        <h2 class="text-lg font-semibold text-text-primary mb-4">Datos personales</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-text-primary mb-1.5">Nombre completo *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary @error('name') border-brand-primary @enderror">
                @error('name')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="document_number" class="block text-sm font-medium text-text-primary mb-1.5">Cédula / ID *</label>
                <input type="text" name="document_number" id="document_number" value="{{ old('document_number', $user->document_number) }}" required
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary @error('document_number') border-brand-primary @enderror">
                @error('document_number')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-text-primary mb-1.5">Teléfono *</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary @error('phone') border-brand-primary @enderror">
                @error('phone')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="email" class="block text-sm font-medium text-text-primary mb-1.5">Correo electrónico *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary @error('email') border-brand-primary @enderror">
                @error('email')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="sc-card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <div>
                <h2 class="text-lg font-semibold text-text-primary">Ubicación de entrega</h2>
                <p class="text-sm text-text-secondary mt-1">Estos datos se usarán automáticamente en tu carrito al comprar.</p>
            </div>
            <a href="{{ route('cart.show') }}" class="sc-btn sc-btn-secondary text-sm shrink-0">Ir al carrito</a>
        </div>

        <div class="mb-4">
            <span class="block text-sm font-medium text-text-primary mb-2">Método de entrega predeterminado *</span>
            <div class="grid grid-cols-2 gap-3 max-w-md">
                <label class="border border-border-default rounded-lg p-3 flex flex-col items-center gap-1 cursor-pointer hover:bg-bg-muted transition-colors">
                    <input type="radio" name="default_delivery_type" value="llevar" class="accent-brand-primary"
                           {{ old('default_delivery_type', $user->default_delivery_type ?? 'llevar') === 'llevar' ? 'checked' : '' }}>
                    <span class="text-sm font-medium mt-1">Para Llevar</span>
                </label>
                <label class="border border-border-default rounded-lg p-3 flex flex-col items-center gap-1 cursor-pointer hover:bg-bg-muted transition-colors">
                    <input type="radio" name="default_delivery_type" value="local" class="accent-brand-primary"
                           {{ old('default_delivery_type', $user->default_delivery_type) === 'local' ? 'checked' : '' }}>
                    <span class="text-sm font-medium mt-1">Consumo Local</span>
                </label>
            </div>
            @error('default_delivery_type')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
        </div>

        <div id="profile-address-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 {{ old('default_delivery_type', $user->default_delivery_type ?? 'llevar') === 'local' ? 'hidden' : '' }}">
            <div>
                <label for="address_neighborhood" class="block text-sm font-medium text-text-primary mb-1.5">Barrio</label>
                <input type="text" name="address_neighborhood" id="address_neighborhood"
                       value="{{ old('address_neighborhood', $user->address_neighborhood) }}" placeholder="Ej. La Floresta"
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary @error('address_neighborhood') border-brand-primary @enderror">
                @error('address_neighborhood')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="address_main_street" class="block text-sm font-medium text-text-primary mb-1.5">Calle principal</label>
                <input type="text" name="address_main_street" id="address_main_street"
                       value="{{ old('address_main_street', $user->address_main_street) }}" placeholder="Ej. Av. de los Shyris"
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary @error('address_main_street') border-brand-primary @enderror">
                @error('address_main_street')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="address_secondary_street" class="block text-sm font-medium text-text-primary mb-1.5">Calle secundaria</label>
                <input type="text" name="address_secondary_street" id="address_secondary_street"
                       value="{{ old('address_secondary_street', $user->address_secondary_street) }}" placeholder="Ej. Calle El Universo"
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary @error('address_secondary_street') border-brand-primary @enderror">
                @error('address_secondary_street')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="address_reference" class="block text-sm font-medium text-text-primary mb-1.5">Referencia o número de casa</label>
                <input type="text" name="address_reference" id="address_reference"
                       value="{{ old('address_reference', $user->address_reference) }}" placeholder="Ej. Casa blanca, portón negro"
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary @error('address_reference') border-brand-primary @enderror">
                @error('address_reference')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="sc-card p-6">
        <h2 class="text-lg font-semibold text-text-primary mb-4">Cambiar contraseña</h2>
        <p class="text-sm text-text-secondary mb-4">Déjala en blanco si no deseas cambiarla.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-medium text-text-primary mb-1.5">Nueva contraseña</label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary @error('password') border-brand-primary @enderror">
                @error('password')<p class="text-xs text-brand-primary mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-text-primary mb-1.5">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full px-4 py-3 rounded-lg border border-border-default bg-bg-base text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary">
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <button type="submit" class="sc-btn sc-btn-primary justify-center">Guardar cambios</button>
        <a href="{{ route('client.dashboard') }}" class="sc-btn sc-btn-secondary justify-center">Cancelar</a>
    </div>
</form>

<script>
    (function () {
        const addressFields = document.getElementById('profile-address-fields');
        const deliveryRadios = document.querySelectorAll('input[name="default_delivery_type"]');
        if (!addressFields || !deliveryRadios.length) return;

        function toggleAddressFields() {
            const isDelivery = document.querySelector('input[name="default_delivery_type"]:checked')?.value === 'llevar';
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
@endsection
