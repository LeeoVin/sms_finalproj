<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>

<body style="display:flex; justify-content:center; align-items:center; height:100vh; background:#322922;">

<div style="background:#FFF0CF; padding:2rem; border-radius:10px; width:250px; text-align:center;">
    <h3>Login</h3>

    @if(session('error'))
        <div style="color:red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <input type="text" name="username" placeholder="Username" required style="width:100%; margin-bottom:10px;">
        <input type="password" name="password" placeholder="Password" required style="width:100%; margin-bottom:10px;">
        <button type="submit" style="background:#E93F0C; color:white;">Login</button>
    </form>
</div>

</body>
</html>