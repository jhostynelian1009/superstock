@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-5 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-text-primary">@yield('page_title', 'Mi cuenta')</h1>
        <p class="text-sm text-text-secondary mt-1">@yield('page_subtitle', 'Gestiona tus pedidos y compras')</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg border border-green-200 bg-green-50 text-green-800 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @yield('client_content')
</div>
@endsection
