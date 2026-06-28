<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->with(['user', 'items'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $pedido): View
    {
        $pedido->load(['user', 'items']);

        return view('admin.orders.show', ['order' => $pedido]);
    }
}
