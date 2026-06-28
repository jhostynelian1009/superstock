<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_access_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document_number', 30);
            $table->string('phone', 30);
            $table->string('email');
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->string('status', 20)->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index(['status', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_access_requests');
    }
};
