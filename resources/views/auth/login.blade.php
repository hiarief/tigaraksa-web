<!DOCTYPE html>
<html lang="en">

<head>

    <title>Login</title>
    <meta charset="UTF-8">
</head>

<body>
    <h2>Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label>Email atau Username</label>
            <input type="text" name="login" required autofocus>

        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <input type="checkbox" name="remember"> Remember me
        </div>

        <button type="submit">Login</button>

        @error('email')
            <div>{{ $message }}</div>
        @enderror
    </form>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
