<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $search = request()->string('search')->trim()->toString();

        $inventories = Inventory::query()
            ->with(['product', 'product.category'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('product', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($q3) use ($search) {
                            $q3->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.inventory.index', compact('inventories', 'search'));
    }
}
