<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalProducts = Product::query()->count();
        $totalCategories = Category::query()->count();
        $totalSuppliers = Supplier::query()->count();
        $lowStockCount = Inventory::query()
            ->whereColumn('current_stock', '<=', 'minimum_stock')
            ->count();

        $metrics = [
            'productos' => [
                'label' => 'Productos registrados',
                'value' => (string) $totalProducts,
                'description' => 'Total en el sistema',
                'icon' => 'cube',
                'variant' => 'productos',
            ],
            'categorias' => [
                'label' => 'Categorías',
                'value' => (string) $totalCategories,
                'description' => 'Clasificaciones activas',
                'icon' => 'tag',
                'variant' => 'categorias',
            ],
            'proveedores' => [
                'label' => 'Proveedores',
                'value' => (string) $totalSuppliers,
                'description' => 'Registrados en el sistema',
                'icon' => 'building-office',
                'variant' => 'proveedores',
            ],
            'stock_bajo' => [
                'label' => 'Productos con stock bajo',
                'value' => (string) $lowStockCount,
                'description' => 'Existencia en o bajo el mínimo',
                'icon' => 'exclamation-triangle',
                'variant' => 'stock-bajo',
            ],
        ];

        $lowStockAlerts = Inventory::query()
            ->with('product')
            ->whereColumn('current_stock', '<=', 'minimum_stock')
            ->orderBy('current_stock')
            ->take(10)
            ->get();

        $recentMovements = InventoryMovement::query()
            ->with(['product', 'user'])
            ->orderByDesc('occurred_at')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'user',
            'metrics',
            'lowStockAlerts',
            'recentMovements',
        ));
    }
}
