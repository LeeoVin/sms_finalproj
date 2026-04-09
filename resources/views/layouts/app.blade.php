<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Supplier Management')</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --red-orange: #E93F0C;
            --dark-brown: #322922;
            --gold-yellow: #FAAA15;
            --light-yellow: #FFF0CF;
        }

        /* BODY */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #f5f7fa;
        }

        /* NAVBAR */
        .head-bar {
            background-color: var(--red-orange);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            margin: 0 12px;
            font-weight: 500;
            transition: 0.2s;
        }

        .nav-link:hover {
            opacity: 0.8;
        }

        /* CONTAINER */
        .container {
            max-width: 1100px;
            margin: auto;
            padding: 2rem;
        }

        /* BUTTON */
        .btn {
            background-color: var(--red-orange);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        /* CARD */
        .card {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f1f1f1;
            padding: 0.7rem;
            text-align: left;
        }

        td {
            padding: 0.7rem;
            border-bottom: 1px solid #eee;
        }

        /* DASHBOARD CARDS */
        .dashboard-card {
            width: 200px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-6px);
        }

        /* ICON */
        .icon-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--red-orange);
            margin: 0 auto 1rem auto;
            transition: 0.3s;
        }

        .dashboard-card:hover .icon-circle {
            transform: scale(1.1);
        }

        .icon-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ALERT */
        .alert-success {
            background: #d4edda;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        /* SIDEBAR LINKS */
        .side-link {
            display:block;
            color:white;
            text-decoration:none;
            margin-bottom:15px;
            padding:10px;
            border-radius:6px;
            transition:0.2s;
        }

        .side-link:hover {
            background:rgba(255,255,255,0.2);
        }

        /* TOP LINKS */
        .top-link {
            margin-left:15px;
            text-decoration:none;
            color:#333;
            font-weight:500;
        }

        .top-link:hover {
            color:#E93F0C;
        }
    </style>
</head>

<body>

<div style="display:flex; height:100vh;">

    <!-- SIDEBAR -->
    <div style="
        width:220px;
        background:#E93F0C;
        color:white;
        padding:20px;
    ">
        <h2 style="margin-bottom:30px;">🍔 Sulit Burger</h2>

        @if(session('role') === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="side-link">Home</a>
            <a href="{{ route('admin.employees.index') }}" class="side-link">Employees</a>
            <a href="{{ route('admin.suppliers.index') }}" class="side-link">Suppliers</a>
            <a href="{{ route('admin.orders.index') }}" class="side-link">Orders</a>

        @elseif(session('role') === 'supervisor')
            <a href="{{ route('supervisor.dashboard') }}" class="side-link">Home</a>
            <a href="{{ route('supervisor.orders.index') }}" class="side-link">Orders</a>
            <a href="{{ route('supervisor.history') }}" class="side-link">Order History</a>
            <a href="{{ route('supervisor.suppliers') }}" class="side-link">Suppliers</a>
        @endif
    </div>

    <!-- MAIN AREA -->
    <div style="flex:1; display:flex; flex-direction:column;">

        <!-- TOP BAR -->
        <div style="
            background:white;
            padding:15px 25px;
            display:flex;
            justify-content:flex-end;
            box-shadow:0 2px 5px rgba(0,0,0,0.05);
        ">
            <a href="{{ route('logout') }}" class="top-link">Logout</a>
        </div>

        <!-- CONTENT -->
        <div style="padding:25px; background:#f5f7fa; flex:1; overflow:auto;">

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')

        </div>

    </div>

</div>

</body>
</html>