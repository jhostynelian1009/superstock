<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::query()->count();
        $activeProducts = Product::query()->where('is_active', true)->count();
        $totalOrders = Order::query()->count();
        $totalClients = User::query()->where('role', User::ROLE_CLIENT)->count();
        $totalSales = Order::query()->sum('total');

        $metrics = [
            'ventas' => [
                'label' => 'Total Ventas',
                'value' => '$'.number_format($totalSales, 2),
                'change' => $totalOrders.' pedidos',
                'direction' => 'up',
                'icon' => 'currency-dollar',
            ],
            'pedidos' => [
                'label' => 'Total Pedidos',
                'value' => (string) $totalOrders,
                'change' => 'registrados',
                'direction' => 'up',
                'icon' => 'shopping-cart',
            ],
            'productos' => [
                'label' => 'Total Productos',
                'value' => (string) $totalProducts,
                'change' => (string) $activeProducts.' activos',
                'direction' => 'up',
                'icon' => 'cube',
            ],
            'clientes' => [
                'label' => 'Total Clientes',
                'value' => (string) $totalClients,
                'change' => 'registrados',
                'direction' => 'up',
                'icon' => 'users',
            ],
        ];

        $recentOrders = Order::query()
            ->with(['user', 'items'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn (Order $order) => [
                'id' => $order->order_number,
                'cliente' => $order->customer_name,
                'productos' => $order->items->pluck('product_name')->take(3)->join(', '),
                'total' => '$'.number_format($order->total, 2),
                'estado' => match ($order->status) {
                    'sent', 'completed' => 'completado',
                    'cancelled' => 'cancelado',
                    default => 'pendiente',
                },
                'estado_label' => $order->statusLabel(),
                'fecha' => $order->created_at->diffForHumans(),
                'url' => route('admin.pedidos.show', $order),
            ]);

        $recentProducts = Product::query()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        // ── Estadísticas Semanales (Mock) ──
        $weeklyStats = [
            ['day' => 'Lun', 'sales' => 18, 'percent' => 72],
            ['day' => 'Mar', 'sales' => 24, 'percent' => 96],
            ['day' => 'Mié', 'sales' => 15, 'percent' => 60],
            ['day' => 'Jue', 'sales' => 21, 'percent' => 84],
            ['day' => 'Vie', 'sales' => 25, 'percent' => 100],
            ['day' => 'Sáb', 'sales' => 20, 'percent' => 80],
            ['day' => 'Dom', 'sales' => 12, 'percent' => 48],
        ];

        // ── Actividad Reciente (Mock) ──
        $recentActivity = [
            [
                'type' => 'order',
                'text' => '<strong>María López</strong> realizó un nuevo pedido por <strong>$8.50</strong>',
                'time' => 'Hace 15 minutos',
            ],
            [
                'type' => 'product',
                'text' => 'Se agregó <strong>Croissant Integral</strong> al catálogo',
                'time' => 'Hace 45 minutos',
            ],
            [
                'type' => 'user',
                'text' => '<strong>Carlos Gutiérrez</strong> se registró como nuevo cliente',
                'time' => 'Hace 1 hora',
            ],
            [
                'type' => 'alert',
                'text' => '<strong>Brownie Premium</strong> tiene stock agotado',
                'time' => 'Hace 2 horas',
            ],
            [
                'type' => 'order',
                'text' => '<strong>Ana Morales</strong> completó su pedido #ORD-2046',
                'time' => 'Hace 3 horas',
            ],
            [
                'type' => 'product',
                'text' => 'Se actualizó el precio de <strong>Chips de Vegetales</strong>',
                'time' => 'Hace 5 horas',
            ],
        ];

        return view('admin.dashboard', compact(
            'metrics',
            'recentOrders',
            'recentProducts',
            'weeklyStats',
            'recentActivity'
        ));
    }
}
