<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
        }

        .login-wrapper {
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .logo-container {
            width: 200px;
            height: 200px; 
            margin: 0 auto;
            position: relative;
            z-index: 10; 
            
            background-color: #ffffff;
            border-radius: 50%;
            border: 2px solid #FAAA15;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); 
            
            overflow: hidden; 
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            border-radius: 50%; 
        }

        .form-card {
            background-color: #ffffff; 
            padding: 100px 40px 60px 40px; 
            margin-top: -75px; 
            border-radius: 20px;
            
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); 
            border: 1px solid rgba(0, 0, 0, 0.05); 
            position: relative;
            z-index: 5; 
        }

        .form-card h2 {
            font-size: 26px;
            font-weight: 600;
            color: #322922; 
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 40px;
        }

        .input-group {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #322922; 
            margin-bottom: 30px;
            padding: 8px 0;
            transition: all 0.3s;
        }

        .input-group:focus-within {
            border-bottom-color: #E93F0C;
        }

        .input-group i {
            width: 30px;
            font-size: 18px;
            color: #322922;
        }

        .input-group input {
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
            padding: 8px 10px;
            font-size: 16px;
            color: #322922;
        }

        .btn-sign-in {
            background-color: #E93F0C; 
            color: #ffffff;
            border: none;
            width: 100%;
            padding: 14px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 30px; 
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            text-transform: uppercase;
            margin-top: 15px;
            box-shadow: 0 4px 12px rgba(233, 63, 12, 0.2); 
        }

        .btn-sign-in:hover {
            background-color: #322922; 
            transform: translateY(-2px);
        }

        .error-alert {
            color: #E93F0C;
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="logo-container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <div class="form-card">
        <h2>Login</h2>

        @if(session('error'))
            <div class="error-alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required value="{{ old('username') }}">
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required value="{{ old('email') }}">
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-sign-in">Sign In</button>
        </form>
    </div>
</div>

</body>
</html>