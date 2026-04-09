@extends('layouts.app')

@section('title', 'Home')

@section('content')

<h2 style="margin-bottom:30px; text-align:center;">Welcome, Admin</h2>

<div style="
    display: flex;
    justify-content: center;  /* centers all cards horizontally */
    gap: 40px;               /* horizontal gap between cards */
    flex-wrap: wrap;          /* allows wrapping if screen is small */
">

    <!-- Employees Card -->
    <div class="card dashboard-card"
         onclick="location.href='{{ route('admin.employees.index') }}'">
        <div class="icon-circle">
            <img src="{{ asset('images/1.png') }}">
        </div>
        <h3>Employees</h3>
    </div>

    <!-- Suppliers Card -->
    <div class="card dashboard-card"
         onclick="location.href='{{ route('admin.suppliers.index') }}'">
        <div class="icon-circle">
            <img src="{{ asset('images/2.png') }}">
        </div>
        <h3>Suppliers</h3>
    </div>

    <!-- Orders Card -->
    <div class="card dashboard-card"
         onclick="location.href='{{ route('admin.orders.index') }}'">
        <div class="icon-circle">
            <img src="{{ asset('images/3.png') }}">
        </div>
        <h3>Orders</h3>
    </div>

</div>

@endsection