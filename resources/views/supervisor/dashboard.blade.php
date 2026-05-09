@extends('layouts.app')

@section('title', 'Supervisor Dashboard')

@section('content')

<h2 style="margin-bottom:20px;">Supervisor Dashboard</h2>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- ================= SALES CHART ================= --}}
<div style="background:white; padding:20px; border-radius:12px; margin-bottom:25px;">
    <h3>Monthly Sales Overview</h3>

    <canvas id="salesChart"></canvas>
</div>

<script>
const salesCtx = document.getElementById('salesChart');

const chartData = {!! json_encode(
    collect($chartData)->map(function ($item) {
        return [
            'label' => $item['label'],
            'data' => $item['data'],
            'borderWidth' => 2,
            'tension' => 0.3
        ];
    })
) !!};

new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: [
            'Jan','Feb','Mar','Apr','May','Jun',
            'Jul','Aug','Sep','Oct','Nov','Dec'
        ],
        datasets: chartData
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true }
        }
    }
});
</script>

{{-- ================= STATS ================= --}}
<div class="dashboard-grid">

    <div class="dashboard-card">
        <h2>{{ $pendingOrders ?? 0 }}</h2>
        <p>Pending Orders</p>
    </div>

    <div class="dashboard-card">
        <h2>{{ $approvedOrders ?? 0 }}</h2>
        <p>Approved Orders</p>
    </div>

    <div class="dashboard-card">
        <h2>{{ $pendingAdjustments ?? 0 }}</h2>
        <p>Item Adjustments</p>
    </div>

</div>

<br>

{{-- ================= ADJUSTMENTS ================= --}}
<h3>Pending Item Adjustment Requests</h3>

<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Requested By</th>
            <th>Branch</th>
            <th>Quantity</th>
            <th>Reason</th>
            <th style="text-align:center;">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($adjustments as $adj)
        <tr>
            <td>{{ $adj->item->item_name }}</td>
            <td>{{ $adj->user->username }}</td>
            <td>{{ $adj->branch }}</td>
            <td>{{ $adj->quantity }}</td>
            <td>{{ $adj->reason }}</td>

            <td>
                <div class="action-buttons">

                    <form method="POST" action="{{ route('supervisor.adjustment.approve', $adj->id) }}">
                        @csrf
                        <button class="btn-add">Approve</button>
                    </form>

                    <form method="POST" action="{{ route('supervisor.adjustment.reject', $adj->id) }}">
                        @csrf
                        <button class="btn-delete">Reject</button>
                    </form>

                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">No pending requests</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection