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

        $solicitud->storeVerificationCode($plainCode);
        $solicitud->update([
            'approved_by' => auth()->id(),
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
}
