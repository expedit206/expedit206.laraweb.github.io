<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    
    @if ($errors->any())
    @foreach ($errors->all() as $error )
        <li>{{ $error }}</li>
    @endforeach
    @endif

    @if (@session('error'))
    <li>

        {{session('error')}}
    </li>
    @endif
    
    @if (@session('success'))
        <li>{{ session('success') }}</li>
    @endif
        
    <form action="{{ route('admin.login.submit') }}" method="post">
        @csrf

        <input type="text" name="email" placeholder="Email"><br>
        <input type="password" name="password" placeholder="password"><br>

        <button type="submit">Login</button>
    </form>
    
    <a href="{{ route('admin.forget.password') }}">Forget password</a>
</body>
</html>