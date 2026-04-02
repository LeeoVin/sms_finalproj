@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('headbar', 'Admin Dashboard')

@section('content')
    <!-- Quick Stats Card -->
    <div class="card">
        <div class="card-header">Quick Stats</div>
        <div style="display:flex; gap:1rem; flex-wrap:wrap;">

    <div class="card" style="flex:1;">
        <div class="card-header">Employees</div>
        <h2>{{ $employeeCount }}</h2>
    </div>

    <div class="card" style="flex:1;">
        <div class="card-header">Suppliers</div>
        <h2>{{ $supplierCount }}</h2>
    </div>

    <div class="card" style="flex:1;">
        <div class="card-header">Orders</div>
        <h2>{{ $orderCount }}</h2>
    </div>

</div>
    </div>

    <!-- Actions Card -->
    <div class="card">
        <div class="card-header">Actions</div>
        <button class="btn" onclick="location.href='{{ route('admin.employees.index') }}'">
    Manage Employees
</button>

<button class="btn" onclick="location.href='{{ route('admin.suppliers.index') }}'">
    Manage Suppliers
</button>

<button class="btn" onclick="location.href='{{ route('admin.orders.index') }}'">
    View Orders
</button>
    </div>
@endsection