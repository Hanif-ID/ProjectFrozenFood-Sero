<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('purchase_orders', function (Blueprint $table) {
        $table->id();
        $table->string('po_code')->unique();
        $table->foreignId('vendor_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
        $table->string('status')->default('menunggu_konfirmasi'); // menunggu_konfirmasi, disetujui, ditolak, selesai
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
