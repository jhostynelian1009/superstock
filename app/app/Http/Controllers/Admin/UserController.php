<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $clients = User::query()
            ->where('role', User::ROLE_CLIENT)
            ->withCount('orders')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('clients'));
    }
}
