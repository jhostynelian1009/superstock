<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $recentOrders = Order::query()
            ->where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact('user', 'recentOrders'));
    }
}
