<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReturn;
use App\Models\PurchaseOrder;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->get();

        $summary = [
            'active_pos'      => PurchaseOrder::whereIn('status', ['menunggu_konfirmasi', 'disetujui'])->count(),
            'in_transit'      => Shipment::whereIn('status', ['disiapkan', 'dikirim', 'hampir_tiba'])->count(),
            'low_stock_items' => $lowStockProducts->count(),
            'pending_returns' => ProductReturn::whereIn('status', ['diajukan', 'disetujui_vendor'])->count(),
            'total_users'     => User::count(),
        ];

        $shipments = Shipment::with('purchaseOrder.vendor')
            ->whereIn('status', ['disiapkan', 'dikirim', 'hampir_tiba'])
            ->latest()
            ->take(5)
            ->get();

        $recentReturns = ProductReturn::with(['product', 'purchaseOrder'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'summary',
            'shipments',
            'lowStockProducts',
            'recentReturns'
        ));
    }
}