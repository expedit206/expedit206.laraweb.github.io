<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset password</title>
</head>
<body>
    <h2>Reset password</h2>
    
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
        
    <form action="{{ route('admin.reset.password.submit') }}" method="post">
        @csrf

        <input type="hidden" name="email" value="{{$email}}" style="visibility:hidden"><br>
        <input type="hidden" name="token" value="{{ $token }}" style="visibility:hidden"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input type="password" name="password_confirmation" placeholder="Confirm Password"><br>
   
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>