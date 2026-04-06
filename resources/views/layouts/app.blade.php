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

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: var(--dark-brown);
        }

        /* TOP NAV */
        .head-bar {
            background-color: var(--red-orange);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        /* BUTTONS */
        .btn {
            background-color: var(--red-orange);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            margin: 5px;
        }

        /* CARDS */
        .card {
            background-color: var(--light-yellow);
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 6px 15px rgba(0,0,0,0.25);
        }

        .card-header {
            background-color: var(--gold-yellow);
            padding: 0.6rem;
            border-radius: 6px;
            font-weight: bold;
            margin-bottom: 0.7rem;
            text-align: center;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: var(--gold-yellow);
            padding: 0.5rem;
            text-align: left;
        }

        td {
            padding: 0.6rem;
            border-bottom: 1px solid #ccc;
        }
        /* DASHBOARD CARDS */
.dashboard-card {
    width: 200px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
}

.dashboard-card:hover {
    transform: translateY(-5px);
}

/* ICON CIRCLE */
.icon-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden; 
    border: 4px solid var(--red-orange);
    margin: 0 auto 1rem auto;
}

.dashboard-card:hover .icon-circle {
    transform: scale(1.1);
}

.icon-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover; 
}
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="head-bar">

    <div><strong>Sulit Burger Admin</strong></div>

    <div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
       
    </div>

    <div>
       <a href="{{ route('logout') }}" class="nav-link">Logout</a>
    </div>

</div>

<!-- CONTENT -->
<div style="display:flex; justify-content:center; padding:2rem;">
    <div style="width:900px;">

        @if(session('success'))
            <div style="background:#d4edda; padding:10px; margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')

    </div>
</div>

</body>
</html>