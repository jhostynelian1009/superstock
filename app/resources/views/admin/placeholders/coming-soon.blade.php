@extends('layouts.admin')

@section('title', $title ?? 'Próximamente')
@section('breadcrumb', $breadcrumb ?? 'Próximamente')

@section('content')
    <div class="dashboard-welcome">
        <div class="dashboard-welcome-text">
            <h1>{{ $title ?? 'Próximamente' }}</h1>
            <p>{{ $description ?? 'Esta sección estará disponible en una próxima versión.' }}</p>
        </div>
        <div class="quick-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Volver al Dashboard
            </a>
        </div>
    </div>

    <div class="admin-alert admin-alert--warning">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
        </svg>
        <div class="admin-alert-content">
            <div class="admin-alert-title">Módulo en desarrollo</div>
            <div>Esta funcionalidad es un placeholder temporal. Los enlaces del panel ya están conectados y listos para integración futura.</div>
        </div>
    </div>
@endsection
