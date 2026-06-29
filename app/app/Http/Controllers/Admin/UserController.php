<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()
            ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_EMPLOYEE])
            ->latest('created_at');

        // Búsqueda por nombre o correo
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario): View
    {
        return view('admin.users.edit', compact('usuario'));
    }

    public function update(UpdateUserRequest $request, User $usuario): RedirectResponse
    {
        $data = $request->validated();

        // Si la contraseña está vacía, no incluirla en la actualización
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $usuario->update($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        // Prevenir eliminar al usuario autenticado
        if ($usuario->id === auth()->id()) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        // Prevenir eliminar al único administrador principal
        $adminCount = User::where('role', User::ROLE_ADMIN)->count();
        if ($usuario->isAdmin() && $adminCount === 1) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'No puedes eliminar el único administrador del sistema.');
        }

        $usuario->delete();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    public function toggleActive(User $usuario): RedirectResponse
    {
        // Prevenir desactivar al usuario autenticado
        if ($usuario->id === auth()->id()) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'No puedes desactivar tu propio usuario.');
        }

        // Prevenir desactivar al único administrador principal
        $activeAdmins = User::where('role', User::ROLE_ADMIN)
            ->where('is_active', true)
            ->count();

        if ($usuario->isAdmin() && $activeAdmins === 1 && $usuario->is_active) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'No puedes desactivar el único administrador activo del sistema.');
        }

        $usuario->update(['is_active' => !$usuario->is_active]);

        $action = $usuario->is_active ? 'activado' : 'desactivado';

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', "Usuario {$action} correctamente.");
    }
}
