<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'business_name' => 'Distribuidora El Cóndor',
                'tax_identifier' => '1791234567001',
                'contact_name' => 'Carlos Mendoza',
                'phone' => '0991234567',
                'email' => 'ventas@elcondor.com.ec',
                'is_active' => true,
            ],
            [
                'business_name' => 'Alimentos Ecuador',
                'tax_identifier' => '1797654321001',
                'contact_name' => 'Ana Lucía Guerrero',
                'phone' => '0987654321',
                'email' => 'contacto@alimentosecuador.com',
                'is_active' => true,
            ],
            [
                'business_name' => 'Super Proveedores',
                'tax_identifier' => '1791112223001',
                'contact_name' => 'Pedro Cevallos',
                'phone' => '0990001112',
                'email' => 'pedidos@superproveedores.com',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::query()->updateOrCreate(
                ['tax_identifier' => $supplier['tax_identifier']],
                $supplier
            );
        }
    }
}
