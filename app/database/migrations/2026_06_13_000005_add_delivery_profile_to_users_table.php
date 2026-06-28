<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('default_delivery_type', 20)->default('llevar')->after('phone');
            $table->string('address_neighborhood')->nullable()->after('default_delivery_type');
            $table->string('address_main_street')->nullable()->after('address_neighborhood');
            $table->string('address_secondary_street')->nullable()->after('address_main_street');
            $table->string('address_reference')->nullable()->after('address_secondary_street');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'default_delivery_type',
                'address_neighborhood',
                'address_main_street',
                'address_secondary_street',
                'address_reference',
            ]);
        });
    }
};
