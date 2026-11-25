@extends('layouts.app')

@section('title', 'Dashboard Admin - Sero Frozen Food')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h4 class="fw-bold mb-1">Dashboard Admin — Sero Frozen Food</h4>
            <p class="text-muted mb-0">Pemantauan PO vendor, estimasi kedatangan frozen food, stok menipis, dan retur.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-group me-1"></i> Kelola Pengguna ({{ $summary['total_users'] }})
            </a>
            <a href="#pelacakan-pengiriman" class="btn btn-primary">
                <i class="bx bx-package me-1"></i> Pantau Pengiriman
            </a>
        </div>
    </div>

    {{-- Kartu Ringkasan KPI --}}
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1 text-muted">PO Aktif</span>
                    <h3 class="card-title mb-2">{{ $summary['active_pos'] }}</h3>
                    <small class="text-primary fw-semibold"><i class="bx bx-file"></i> Pesanan ke vendor</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1 text-muted">Dalam Pengiriman</span>
                    <h3 class="card-title mb-2">{{ $summary['in_transit'] }}</h3>
                    <small class="text-info fw-semibold"><i class="bx bx-time-five"></i> Siapkan ruang freezer</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1 text-muted">Stok Menipis</span>
                    <h3 class="card-title mb-2">{{ $summary['low_stock_items'] }}</h3>
                    <small class="text-warning fw-semibold"><i class="bx bx-error"></i> Di bawah batas minimum</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1 text-muted">Retur Berjalan</span>
                    <h3 class="card-title mb-2">{{ $summary['pending_returns'] }}</h3>
                    <small class="text-danger fw-semibold"><i class="bx bx-transfer-alt"></i> Menunggu penggantian</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Tabel Pelacakan Status & Estimasi Kedatangan --}}
        <div class="col-lg-7" id="pelacakan-pengiriman">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Status & Estimasi Kedatangan Vendor</h5>
                    <span class="badge bg-label-primary">Pengiriman Aktif</span>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. PO</th>
                                <th>Vendor</th>
                                <th>Status</th>
                                <th>Estimasi Tiba</th>
                                <th>Prioritas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shipments as $shipment)
                                <tr>
                                    <td><strong>{{ $shipment->purchaseOrder->po_code ?? '-' }}</strong></td>
                                    <td>{{ $shipment->purchaseOrder->vendor->name ?? '-' }}</td>
                                    <td><span class="badge bg-label-info text-uppercase">{{ str_replace('_', ' ', $shipment->status) }}</span></td>
                                    <td>{{ $shipment->estimated_arrival ? $shipment->estimated_arrival->format('d M Y, H:i') : 'Belum diisi' }}</td>
                                    <td>
                                        @if ($shipment->is_frozen_priority)
                                            <span class="badge bg-label-primary">Frozen Prioritas</span>
                                        @endif
                                        @if ($shipment->is_delayed)
                                            <span class="badge bg-label-danger">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada pengiriman aktif.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tabel Peringatan Stok Menipis & Saran Jumlah Pesanan --}}
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Stok Menipis & Saran Order</h5>
                    <span class="badge bg-label-warning">Restock</span>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Sisa / Min</th>
                                <th>Saran Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lowStockProducts as $product)
                                @php
                                    $suggestedQty = max(($product->min_stock * 2) - $product->stock, 5);
                                @endphp
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <span class="text-danger fw-semibold">{{ $product->stock }}</span> / {{ $product->min_stock }} {{ $product->unit }}
                                    </td>
                                    <td>
                                        <span class="badge bg-label-success">+{{ $suggestedQty }} {{ $product->unit }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Semua stok produk aman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tabel Daftar Retur Barang --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Daftar Retur Barang Terbaru</h5>
                    <span class="badge bg-label-secondary">Komplain & Retur</span>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode Retur</th>
                                <th>No. PO</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Alasan / Kondisi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentReturns as $ret)
                                <tr>
                                    <td><strong>{{ $ret->return_code }}</strong></td>
                                    <td>{{ $ret->purchaseOrder->po_code ?? '-' }}</td>
                                    <td>{{ $ret->product->name ?? '-' }}</td>
                                    <td>{{ $ret->qty }}</td>
                                    <td>{{ $ret->reason }}</td>
                                    <td><span class="badge bg-label-warning text-uppercase">{{ str_replace('_', ' ', $ret->status) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data retur barang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection