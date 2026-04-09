@extends('layouts.app')

@section('title', 'Supervisor Dashboard')

@section('content')

<h2 style="margin-bottom:30px; text-align:center;">Welcome, Supervisor</h2>

<div style="
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
">

    <!-- Orders Card -->
    <div class="card dashboard-card"
         onclick="location.href='{{ route('supervisor.orders.index') }}'">
        <div class="icon-circle">
            <img src="{{ asset('images/3.png') }}">
        </div>
        <h3>Orders</h3>
    </div>

    <!-- Order History Card -->
    <div class="card dashboard-card"
         onclick="location.href='{{ route('supervisor.history') }}'">
        <div class="icon-circle">
            <img src="{{ asset('images/4.png') }}">
        </div>
        <h3>Order History</h3>
    </div>

    <!-- Suppliers Card -->
    <div class="card dashboard-card"
         onclick="location.href='{{ route('supervisor.suppliers') }}'">
        <div class="icon-circle">
            <img src="{{ asset('images/2.png') }}">
        </div>
        <h3>Suppliers</h3>
    </div>

</div>

@endsection