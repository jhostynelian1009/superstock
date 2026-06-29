<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role');

        $query = User::query()
            ->latest();

        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%");
            });
        }

        if (filled($roleFilter)) {
            $query->where('role', $roleFilter);
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'search', 'roleFilter'));
    }

    public function toggleStatus(User $usuario): RedirectResponse
    {
        // No permitir desactivar al propio usuario ni al admin primario
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        if ($usuario->isPrimaryAdmin()) {
            return back()->with('error', 'No se puede desactivar al administrador principal.');
        }

        $usuario->update(['is_active' => ! $usuario->is_active]);

        $estado = $usuario->is_active ? 'activado' : 'desactivado';

        return back()->with('success', "Usuario \"{$usuario->name}\" {$estado} correctamente.");
    }

    public function updatePermissions(Request $request, User $usuario): RedirectResponse
    {
        if ($usuario->isPrimaryAdmin()) {
            return back()->with('error', 'No se pueden modificar los permisos del administrador principal.');
        }

        $permissions = $request->input('permissions', []);

        $usuario->update([
            'permissions' => $permissions
        ]);

        return back()->with('success', "Permisos de \"{$usuario->name}\" actualizados correctamente.");
    }
}

