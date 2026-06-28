<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('client.profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'document_number' => ['required', 'string', 'max:30', Rule::unique('users', 'document_number')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'default_delivery_type' => ['required', 'in:llevar,local'],
            'address_neighborhood' => ['required_if:default_delivery_type,llevar', 'nullable', 'string', 'max:100'],
            'address_main_street' => ['required_if:default_delivery_type,llevar', 'nullable', 'string', 'max:150'],
            'address_secondary_street' => ['required_if:default_delivery_type,llevar', 'nullable', 'string', 'max:150'],
            'address_reference' => ['required_if:default_delivery_type,llevar', 'nullable', 'string', 'max:150'],
        ], [
            'address_neighborhood.required_if' => 'Indique el barrio de entrega.',
            'address_main_street.required_if' => 'Indique la calle principal.',
            'address_secondary_street.required_if' => 'Indique la calle secundaria.',
            'address_reference.required_if' => 'Indique una referencia o número de casa.',
        ]);

        if ($data['default_delivery_type'] === 'local') {
            $data['address_neighborhood'] = null;
            $data['address_main_street'] = null;
            $data['address_secondary_street'] = null;
            $data['address_reference'] = null;
        }

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('client.perfil.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}
