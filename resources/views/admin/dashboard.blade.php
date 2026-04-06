@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div style="display:flex; justify-content:center; margin-top:3rem;">

    <div style="display:flex; gap:3rem;">

        <!-- EMPLOYEES CARD -->
        <div class="card dashboard-card" onclick="location.href='{{ route('admin.employees.index') }}'">
            <div class="icon-circle">
                <img src="{{ asset('images/1.png') }}" alt="Employees">
            </div>
            <h3>Employees</h3>
        </div>

        <!-- SUPPLIERS CARD -->
        <div class="card dashboard-card" onclick="location.href='{{ route('admin.suppliers.index') }}'">
            <div class="icon-circle">
                <img src="{{ asset('images/2.png') }}" alt="Suppliers">
            </div>
            <h3>Suppliers</h3>
        </div>

        <!-- ORDERS CARD -->
        <div class="card dashboard-card" onclick="location.href='{{ route('admin.orders.index') }}'">
            <div class="icon-circle">
                <img src="{{ asset('images/3.png') }}" alt="Orders">
            </div>
            <h3>Orders</h3>
        </div>

    </div>

</div>

@endsection