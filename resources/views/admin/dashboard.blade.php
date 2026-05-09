@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Admin Dashboard</h2>

{{-- ================= SUMMARY CARDS ================= --}}
<div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:25px;">

    <div class="dashboard-card">
        <h2>{{ $totalSuppliers }}</h2>
        <p>Suppliers</p>
    </div>

    <div class="dashboard-card">
        <h2>{{ $totalItems }}</h2>
        <p>Items</p>
    </div>

    <div class="dashboard-card">
        <h2>{{ $totalOrders }}</h2>
        <p>Total Orders</p>
    </div>

    <div class="dashboard-card">
        <h2>₱{{ number_format($totalSales, 2) }}</h2>
        <p>Total Sales (Revenue)</p>
    </div>

</div>

{{-- ================= SALES GRAPH ================= --}}
<div style="background:white; padding:20px; border-radius:12px; margin-bottom:25px;">
    <h3>Monthly Sales Trend (Revenue)</h3>
    <canvas id="salesChart" height="120"></canvas>
</div>

{{-- ================= ORDER STATUS CHART ================= --}}
<div style="background:white; padding:20px; border-radius:12px; margin-bottom:25px;">
    <h3>Order Status Overview</h3>
    <canvas id="orderChart" height="120"></canvas>
</div>

{{-- ================= LOW STOCK ================= --}}
<div style="background:#fff3f3; padding:15px; border-radius:10px; margin-bottom:25px;">
    <h3 style="color:#c0392b;">Low Stock Alert</h3>

    @forelse($lowStockItems as $item)
        <p>
            {{ $item->item_name }}
            <strong style="color:red;">({{ $item->stock }})</strong>
        </p>
    @empty
        <p>No low stock items 🎉</p>
    @endforelse
</div>

{{-- ================= RECENT ORDERS ================= --}}
<h3>Recent Orders</h3>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Branch</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        @forelse($recentOrders as $order)
        <tr>
            <td>{{ $order->order_id }}</td>
            <td>{{ $order->user->branch ?? 'N/A' }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->created_at->format('Y-m-d') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align:center;">No orders</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ================= CHART SCRIPT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const salesCtx = document.getElementById('salesChart');

new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            label: 'Sales Revenue (₱)',
            data: {!! json_encode(array_values($salesData)) !!},
            borderColor: '#E93F0C',
            backgroundColor: 'rgba(233, 63, 12, 0.1)',
            tension: 0.3,
            fill: true
        }]
    }
});
</script>

<script>
const ctx = document.getElementById('orderChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Pending', 'Approved', 'Cancelled'],
        datasets: [{
            label: 'Orders',
            data: [
                {{ $pendingOrders }},
                {{ $approvedOrders }},
                {{ $cancelledOrders }}
            ],
            backgroundColor: ['#f39c12','#2ecc71','#e74c3c']
        }]
    }
});
</script>

@endsection