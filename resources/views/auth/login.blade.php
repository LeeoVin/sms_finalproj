<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f5f7fa;
            margin: 0;
        }

        .card {
            width: 320px;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 1.5rem;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
        }

        input:focus {
            border-color: #E93F0C;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #E93F0C;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="card" style="text-align:center; width:250px; padding:2rem; margin:auto;">
    <!-- Circular burger icon -->
    <div style="
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #E93F0C;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 1rem auto;
        font-size: 2.5rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    ">
        🍔
    </div>

    <!-- App Name -->
    <h2 style="margin:0;">Sulit</h2>
    <h2 style="margin:0 0 1rem 0;">Burger</h2>

    <!-- Login heading -->
    <h3 style="margin-bottom:1rem;">Login</h3>

    <!-- Login Form -->
    <form method="POST" action="/login">
        @csrf
        <input type="text" name="username" placeholder="Username" required style="width:100%; margin-bottom:10px; padding:0.5rem; border-radius:5px; border:1px solid #ccc;">
        <input type="password" name="password" placeholder="Password" required style="width:100%; margin-bottom:10px; padding:0.5rem; border-radius:5px; border:1px solid #ccc;">
        <button type="submit" style="background:#E93F0C; color:white; padding:0.5rem 1rem; border:none; border-radius:6px; cursor:pointer; width:100%;">Login</button>
    </form>
</div>

</body>
</html>