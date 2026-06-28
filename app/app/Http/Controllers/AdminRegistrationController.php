<?php

namespace App\Http\Controllers;

use App\Models\AdminAccessRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register-admin');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'document_number' => ['required', 'string', 'max:30'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (User::query()->where('email', $data['email'])->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Ya existe una cuenta con este correo.',
            ]);
        }

        $hasOpenRequest = AdminAccessRequest::query()
            ->where('email', $data['email'])
            ->whereIn('status', [
                AdminAccessRequest::STATUS_PENDING,
                AdminAccessRequest::STATUS_APPROVED,
            ])
            ->exists();

        if ($hasOpenRequest) {
            throw ValidationException::withMessages([
                'email' => 'Ya hay una solicitud activa para este correo. Espera la respuesta del administrador principal.',
            ]);
        }

        AdminAccessRequest::query()->create([
            'name' => $data['name'],
            'document_number' => $data['document_number'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => AdminAccessRequest::STATUS_PENDING,
        ]);

        return redirect()
            ->route('register.admin.verify')
            ->with('success', 'Solicitud enviada. El administrador principal la revisará y, si la aprueba, te entregará un código de acceso para activar tu cuenta.');
    }

    public function showVerify()
    {
        return view('auth.verify-admin');
    }

    public function verify(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'verification_code' => ['required', 'string', 'max:20'],
        ]);

        $accessRequest = AdminAccessRequest::query()
            ->where('email', $data['email'])
            ->where('status', AdminAccessRequest::STATUS_APPROVED)
            ->latest()
            ->first();

        if (! $accessRequest) {
            throw ValidationException::withMessages([
                'email' => 'No hay una solicitud aprobada para este correo. Espera la autorización del administrador principal.',
            ]);
        }

        if ($accessRequest->isExpired()) {
            throw ValidationException::withMessages([
                'verification_code' => 'El código ha expirado. Solicita una nueva aprobación al administrador principal.',
            ]);
        }

        if (! $accessRequest->verifyCode(strtoupper(trim($data['verification_code'])))) {
            throw ValidationException::withMessages([
                'verification_code' => 'El código ingresado no es correcto.',
            ]);
        }

        if (User::query()->where('email', $accessRequest->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Ya existe una cuenta con este correo.',
            ]);
        }

        DB::transaction(function () use ($accessRequest) {
            User::query()->create([
                'name' => $accessRequest->name,
                'document_number' => $accessRequest->document_number,
                'phone' => $accessRequest->phone,
                'email' => $accessRequest->email,
                'password' => $accessRequest->password,
                'role' => User::ROLE_ADMIN,
                'is_primary_admin' => false,
            ]);

            $accessRequest->update([
                'status' => AdminAccessRequest::STATUS_COMPLETED,
                'completed_at' => now(),
            ]);
        });

        return redirect()
            ->route('login')
            ->with('status', 'Cuenta de administrador activada. Ya puedes iniciar sesión seleccionando "Administrador".');
    }
}
