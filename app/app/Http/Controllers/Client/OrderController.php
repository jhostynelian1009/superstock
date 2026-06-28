<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('client.orders.index', compact('orders'));
    }

    public function show(Order $pedido): View
    {
        abort_unless($pedido->user_id === auth()->id(), 403);

        $pedido->load('items');

        return view('client.orders.show', ['order' => $pedido]);
    }
}
