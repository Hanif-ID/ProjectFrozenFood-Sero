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
    Schema::create('shipments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();
        $table->string('status')->default('disiapkan'); // disiapkan, dikirim, hampir_tiba, tiba
        $table->dateTime('estimated_arrival')->nullable();
        $table->boolean('is_frozen_priority')->default(true);
        $table->boolean('is_delayed')->default(false);
        $table->string('temperature_note')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
