<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Supplier Management')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Color palette */
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
            color: black;
        }

        /* Head bar */
        .head-bar {
            background-color: var(--red-orange);
            color: white;
            padding: 1rem 2rem;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Buttons */
        .btn {
            background-color: var(--red-orange);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            margin-right: 0.5rem;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Cards */
        .card {
            background-color: var(--light-yellow);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .card-header {
            font-weight: bold;
            color: var(--gold-yellow);
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.5rem;
        }

        th {
            background-color: var(--gold-yellow);
            color: var(--dark-brown);
            padding: 0.5rem;
            text-align: left;
        }

        td {
            padding: 0.5rem;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="head-bar">
        @yield('headbar', 'Supplier Management')
    </div>

    <div class="container" style="padding: 2rem;">
        @yield('content')
    </div>
</body>
</html>