<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        $search = request()->string('search')->trim()->toString();

        $suppliers = Supplier::query()
            ->when($search, fn ($q) => $q->where('business_name', 'like', "%{$search}%")
                ->orWhere('tax_identifier', 'like', "%{$search}%")
                ->orWhere('contact_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->orderBy('business_name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.suppliers.index', compact('suppliers', 'search'));
    }

    public function create(): View
    {
        return view('admin.suppliers.create');
    }

    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = (bool) ($data['is_active'] ?? true);

        // Normalizar identificador tributario
        if (filled($data['tax_identifier'] ?? null)) {
            $data['tax_identifier'] = strtoupper(trim($data['tax_identifier']));
        } else {
            $data['tax_identifier'] = null;
        }

        Supplier::query()->create($data);

        return redirect()
            ->route('admin.proveedores.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function edit(Supplier $proveedor): View
    {
        return view('admin.suppliers.edit', ['supplier' => $proveedor]);
    }

    public function update(UpdateSupplierRequest $request, Supplier $proveedor): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        // Normalizar identificador tributario
        if (filled($data['tax_identifier'] ?? null)) {
            $data['tax_identifier'] = strtoupper(trim($data['tax_identifier']));
        } else {
            $data['tax_identifier'] = null;
        }

        $proveedor->update($data);

        return redirect()
            ->route('admin.proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Supplier $proveedor): RedirectResponse
    {
        // No eliminar si tiene movimientos asociados
        if ($proveedor->inventoryMovements()->exists()) {
            return redirect()
                ->route('admin.proveedores.index')
                ->with('error', 'No se puede eliminar el proveedor porque tiene movimientos de inventario registrados. Puedes desactivarlo en su lugar.');
        }

        $proveedor->delete();

        return redirect()
            ->route('admin.proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
