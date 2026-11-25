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
    Schema::create('product_returns', function (Blueprint $table) {
        $table->id();
        $table->string('return_code')->unique();
        $table->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();
        $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        $table->integer('qty');
        $table->string('reason');
        $table->string('photo_path')->nullable();
        $table->string('status')->default('diajukan'); // diajukan, disetujui_vendor, diganti
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_returns');
    }
};
