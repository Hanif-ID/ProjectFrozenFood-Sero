<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReturn;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@sero.test'],
            [
                'name'     => 'Paw (Pemilik Toko)',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        $vendor = User::firstOrCreate(
            ['email' => 'vendor@sero.test'],
            [
                'name'     => 'Ocha Frozen Supply',
                'password' => Hash::make('password'),
                'role'     => 'vendor',
            ]
        );

        $nugget = Product::firstOrCreate(
            ['name' => 'Nugget Ayam Original 500g'],
            [
                'category'  => 'nugget',
                'unit'      => 'pack',
                'stock'     => 6,
                'min_stock' => 15,
            ]
        );

        $sosis = Product::firstOrCreate(
            ['name' => 'Sosis Sapi Bakar Jumbo'],
            [
                'category'  => 'sosis',
                'unit'      => 'pack',
                'stock'     => 4,
                'min_stock' => 12,
            ]
        );

        $po = PurchaseOrder::firstOrCreate(
            ['po_code' => 'PO-20261125-001'],
            [
                'vendor_id'  => $vendor->id,
                'created_by' => $admin->id,
                'status'     => 'disetujui',
                'notes'      => 'Kirim pakai box pendingin',
            ]
        );

        PurchaseOrderItem::firstOrCreate(
            [
                'purchase_order_id' => $po->id,
                'product_id'        => $nugget->id,
            ],
            [
                'qty_ordered'   => 25,
                'specification' => 'Kemasan 500g utuh',
            ]
        );

        Shipment::firstOrCreate(
            ['purchase_order_id' => $po->id],
            [
                'status'             => 'dikirim',
                'estimated_arrival'  => now()->addHours(2),
                'is_frozen_priority' => true,
                'is_delayed'         => false,
            ]
        );

        ProductReturn::firstOrCreate(
            ['return_code' => 'RTR-20261125-01'],
            [
                'purchase_order_id' => $po->id,
                'product_id'        => $sosis->id,
                'qty'               => 2,
                'reason'            => 'Kemasan bocor dan produk mulai mencair',
                'status'            => 'diajukan',
            ]
        );
    }
}