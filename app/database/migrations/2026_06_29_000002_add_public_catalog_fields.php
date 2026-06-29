<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique();
        });

        Schema::table('products', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn(['slug', 'price', 'image']);
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->dropColumn('slug');
        });
    }
};
