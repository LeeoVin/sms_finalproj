<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS - Sulit Burger</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .form-container {
    max-width: 500px;
    margin: auto;
}

.page-title {
    margin-bottom: 20px;
    color: var(--dark-brown);
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: var(--dark-brown);
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
}

.full-width {
    width: 100%;
}
        :root {
            --dark-brown: #322922;
            --red-orange: #E93F0C;
            --gold-yellow: #FAAA15;
            --light-yellow: #FBCF72;
            --bg-gray: #ffffff;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-gray);
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: var(--dark-brown);
            position: fixed;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 30px 0;
            text-align: center;
        }

        .sidebar-logo-circle {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            border-radius: 50%;
            border: 3px solid var(--gold-yellow);
            overflow: hidden;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sidebar-logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            flex-grow: 1;
        }

        .nav-links li a {
            color: var(--light-yellow);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 15px 25px;
            transition: 0.3s;
        }

        .nav-links li.active a,
        .nav-links li a:hover {
            background-color: var(--red-orange);
            color: white;
        }

        .nav-links i {
            margin-right: 15px;
            width: 22px;
            min-width: 22px;
            text-align: center;
        }

        .btn-logout-sidebar {
            background: var(--red-orange);
            color: white;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            margin: 20px;
            border-radius: 8px;
        }

        /* MAIN */
        .main-wrapper {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        .content-area {
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .data-card {
            background: white;
            width: 100%;
            max-width: 1000px;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #f0f0f0;
        }

        /* BUTTONS */
        .btn-add, .btn-submit {
            background: var(--red-orange);
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-edit {
    background: var(--gold-yellow);
    color: var(--dark-brown);
    padding: 6px 12px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
}

.btn-delete {
    background: var(--dark-brown);
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
}
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed; /* ✅ FIX ALIGNMENT */
        }

        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: middle;
        }

        th {
            border-bottom: 2px solid #eee;
            color: var(--dark-brown);
        }

        /* Prevent text overflow */
        td {
            word-wrap: break-word;
        }

        /* ACTION BUTTON GROUP */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 6px;
        }
        .action-buttons form {
            margin: 0;
        }

        /* DASHBOARD */
        .dashboard-grid {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .dashboard-card {
            width: 180px;
            text-align: center;
            cursor: pointer;
            padding: 20px;
            border-radius: 15px;
            transition: 0.3s;
        }

        .dashboard-card:hover {
            background: #fdf2f0;
            transform: translateY(-5px);
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--red-orange);
            margin: 0 auto 15px;
        }

        .icon-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* GLOBAL MODAL FIX */
       {{-- GLOBAL MODAL STYLE --}}

.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: #fff;
    margin: 6% auto;
    padding: 25px;
    width: 400px;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.2);
}

.btn-small {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    margin-top: 8px;
}
.notif-badge {
    background: red;
    color: white;
    border-radius: 50%;
    padding: 3px 8px;
    font-size: 12px;
    margin-left: auto;
    font-weight: bold;
}
</style>

<body>

<div class="sidebar">

    <div class="sidebar-header">
        <div class="sidebar-logo-circle">
            <img src="{{ asset('images/logo.png') }}">
        </div>
    </div>

    <ul class="nav-links">

        @if(session('role') === 'admin')

            <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            </li>

            <li class="{{ request()->is('admin/menu*') ? 'active' : '' }}">
                <a href="{{ route('admin.menu') }}">
                    <i class="fas fa-hamburger"></i> Menu
                </a>
            </li>

            <li class="{{ request()->is('admin/suppliers*') ? 'active' : '' }}">
                <a href="{{ route('admin.suppliers.index') }}"><i class="fas fa-truck"></i> Suppliers</a>
            </li>

            <li class="{{ request()->is('admin/employees*') ? 'active' : '' }}">
                <a href="{{ route('admin.employees.index') }}"><i class="fas fa-users"></i> Employees</a>
            </li>

            <li class="{{ request()->is('admin/items*') ? 'active' : '' }}">
                <a href="{{ route('admin.items.index') }}"><i class="fas fa-box"></i> Supplies</a>
            </li>

            <li class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                <a href="{{ route('admin.orders.index') }}"><i class="fas fa-clock"></i> Order History</a>
            </li>

        @elseif(session('role') === 'supervisor')
                @php
        $pendingAdjustments = \App\Models\ItemAdjustment::where(
            'status',
            'pending'
        )->count();
        @endphp

            <li class="{{ request()->is('supervisor/dashboard') ? 'active' : '' }}">
                <a href="{{ route('supervisor.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            </li>

            <li class="{{ request()->is('supervisor/orders*') ? 'active' : '' }}">
                <a href="{{ route('supervisor.orders.index') }}"><i class="fas fa-shopping-cart"></i> Orders</a>
            </li>

            <li class="{{ request()->is('supervisor/history*') ? 'active' : '' }}">
                <a href="{{ route('supervisor.history') }}"><i class="fas fa-clock"></i> Order History</a>
            </li>

            <li class="{{ request()->is('supervisor/suppliers*') ? 'active' : '' }}">
                <a href="{{ route('supervisor.suppliers') }}"><i class="fas fa-truck"></i> Suppliers</a>
            </li>
            <li class="{{ request()->is('supervisor/supplies*') ? 'active' : '' }}">

    <a href="{{ route('supervisor.supplies') }}">

        <i class="fas fa-box"></i>

        Supplies

        @if($pendingAdjustments > 0)

            <span class="notif-badge">
                {{ $pendingAdjustments }}
            </span>

        @endif

    </a>

</li>

        @elseif(session('role') === 'store_manager')

            <li class="{{ request()->is('manager/dashboard') ? 'active' : '' }}">
                <a href="{{ route('manager.dashboard') }}"><i class="fas fa-home"></i> Menu</a>
            </li>

            <li class="{{ request()->is('manager/items*') ? 'active' : '' }}">
                <a href="{{ route('manager.items.index') }}"><i class="fas fa-box"></i> Supplies</a>
            </li>

            <li class="{{ request()->is('manager/suppliers*') ? 'active' : '' }}">
                <a href="{{ route('manager.suppliers') }}"><i class="fas fa-truck"></i> Suppliers</a>
            </li>

            <li class="{{ request()->is('manager/orders/create') ? 'active' : '' }}">
                <a href="{{ route('manager.orders.create') }}"><i class="fas fa-plus-circle"></i> Purchase Order</a>
            </li>

            <li class="{{ request()->is('manager/orders') ? 'active' : '' }}">
                <a href="{{ route('manager.orders.index') }}"><i class="fas fa-shopping-cart"></i> My Orders</a>
            </li>

        @endif

    </ul>

    <a href="{{ route('logout') }}" class="btn-logout-sidebar">LOGOUT</a>
</div>

<div class="main-wrapper">
    <div class="content-area">
        <div class="data-card">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>