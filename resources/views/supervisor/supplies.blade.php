@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Branch Supplies Overview</h2>

{{-- ================= FILTER BAR ================= --}}
<div style="
    background:white;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
">

    <form method="GET" style="display:flex; gap:10px; align-items:center;">

        <label style="font-weight:600;">Select Branch:</label>

        <select name="branch"
                onchange="this.form.submit()"
                style="padding:8px; border-radius:8px; border:1px solid #ddd;">

            <option value="">All Branches</option>

            @foreach($branches as $b)
                <option value="{{ $b }}"
                    {{ $branch == $b ? 'selected' : '' }}>
                    {{ $b }}
                </option>
            @endforeach

        </select>

    </form>

</div>

{{-- ================= STOCK TABLE ================= --}}
<div style="background:white; padding:20px; border-radius:12px; margin-bottom:25px;">

    <h3 style="margin-bottom:15px;">Current Branch Stock</h3>

    <table>
        <thead>
            <tr>
                <th>Branch</th>
                <th>Supply</th>
                <th>Stock</th>
            </tr>
        </thead>

        <tbody>

        @forelse($stocks as $stock)

            <tr>
                <td>{{ $stock->branch }}</td>
                <td>{{ $stock->item->item_name }}</td>

                <td>
                    <span style="
                        padding:4px 10px;
                        border-radius:8px;
                        background:
                            {{ $stock->stock <= 5 ? '#e74c3c' : '#2ecc71' }};
                        color:white;
                        font-weight:600;
                    ">
                        {{ $stock->stock }}
                    </span>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="3" style="text-align:center;">
                    No stock data found
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>

</div>

{{-- ================= ADJUSTMENTS ================= --}}
<div style="background:white; padding:20px; border-radius:12px;">

    <h3 style="margin-bottom:15px;">
        Pending Stock Adjustment Requests
    </h3>

    <table>
        <thead>
            <tr>
                <th>Branch</th>
                <th>Supply</th>
                <th>Qty</th>
                <th>Reason</th>
                <th style="text-align:center;">Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($adjustments as $adjustment)

            <tr>

                <td>{{ $adjustment->branch }}</td>
                <td>{{ $adjustment->item->item_name }}</td>
                <td>{{ $adjustment->quantity }}</td>
                <td>{{ $adjustment->reason }}</td>

                <td style="text-align:center;">

                    <div class="action-buttons">

                        <form method="POST"
                              action="{{ route('supervisor.adjustment.approve', $adjustment->id) }}">
                            @csrf

                            <button class="btn-add">
                                Approve
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('supervisor.adjustment.reject', $adjustment->id) }}">
                            @csrf

                            <button class="btn-delete">
                                Reject
                            </button>
                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5" style="text-align:center;">
                    No pending requests
                </td>
            </tr>

        @endforelse

        </tbody>
    </table>

</div>

@endsection