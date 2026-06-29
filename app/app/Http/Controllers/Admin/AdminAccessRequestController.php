<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAccessRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAccessRequestController extends Controller
{
    public function index(): View
    {
        $requests = AdminAccessRequest::query()
            ->with('approver')
            ->latest()
            ->paginate(15);

        $pendingCount = AdminAccessRequest::query()
            ->where('status', AdminAccessRequest::STATUS_PENDING)
            ->count();

        return view('admin.admin-access-requests.index', compact('requests', 'pendingCount'));
    }

    public function approve(AdminAccessRequest $solicitud): RedirectResponse
    {
        if (! $solicitud->isPending()) {
            return back()->with('error', 'Esta solicitud ya fue procesada.');
        }

        $plainCode = AdminAccessRequest::generatePlainCode();

        $permissions = request()->input('permissions', []);

        $solicitud->storeVerificationCode($plainCode);
        $solicitud->update([
            'approved_by' => auth()->id(),
            'permissions' => $permissions,
        ]);

        return back()->with([
            'success' => 'Solicitud aprobada. Comparte el código con la persona solicitante.',
            'generated_admin_code' => $plainCode,
            'generated_admin_email' => $solicitud->email,
        ]);
    }

    public function reject(Request $request, AdminAccessRequest $solicitud): RedirectResponse
    {
        if (! $solicitud->isPending()) {
            return back()->with('error', 'Esta solicitud ya fue procesada.');
        }

        $data = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $solicitud->update([
            'status' => AdminAccessRequest::STATUS_REJECTED,
            'rejection_reason' => $data['rejection_reason'] ?? 'Solicitud rechazada por el administrador principal.',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Solicitud rechazada correctamente.');
    }

    public function resend(AdminAccessRequest $solicitud): RedirectResponse
    {
        if (! $solicitud->isApproved()) {
            return back()->with('error', 'Solo se puede reenviar el código para solicitudes aprobadas.');
        }

        $plainCode = AdminAccessRequest::generatePlainCode();

        $solicitud->storeVerificationCode($plainCode);
        $solicitud->update([
            'approved_by' => auth()->id(),
            'expires_at' => now()->addHours(24),
        ]);

        return back()->with([
            'success' => 'Nuevo código generado correctamente. Comparte el código con la persona solicitante.',
            'generated_admin_code' => $plainCode,
            'generated_admin_email' => $solicitud->email,
        ]);
    }
}
