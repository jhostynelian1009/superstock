<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('document_number', 30)->nullable()->unique();
            $table->string('phone', 30)->nullable();
            $table->boolean('is_primary_admin')->default(false);
            $table->string('default_delivery_type', 20)->default('llevar');
            $table->string('address_neighborhood', 100)->nullable();
            $table->string('address_main_street', 150)->nullable();
            $table->string('address_secondary_street', 150)->nullable();
            $table->string('address_reference', 150)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'document_number',
                'phone',
                'is_primary_admin',
                'default_delivery_type',
                'address_neighborhood',
                'address_main_street',
                'address_secondary_street',
                'address_reference',
            ]);
        });
    }
};
