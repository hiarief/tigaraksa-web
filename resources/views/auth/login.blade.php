<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login - DesaBisa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Elements */
        .bg-decoration {
            position: absolute;
            opacity: 0.1;
        }

        .mountain {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 40%;
            background: linear-gradient(to top, #2d3748, transparent);
            clip-path: polygon(0 100%, 0 40%, 15% 60%, 30% 35%, 45% 55%, 60% 30%, 75% 50%, 90% 40%, 100% 60%, 100% 100%);
            animation: float 20s ease-in-out infinite;
        }

        .cloud {
            position: absolute;
            background: white;
            border-radius: 100px;
            opacity: 0.2;
            animation: drift 30s linear infinite;
        }

        .cloud1 {
            width: 100px;
            height: 40px;
            top: 15%;
            left: -100px;
        }

        .cloud2 {
            width: 150px;
            height: 50px;
            top: 25%;
            left: -150px;
            animation-delay: 10s;
        }

        .cloud3 {
            width: 120px;
            height: 45px;
            top: 40%;
            left: -120px;
            animation-delay: 20s;
        }

        @keyframes drift {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(100vw + 200px));
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Login Container */
        .login-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 90%;
            max-width: 1000px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Left Side - Branding */
        .login-brand {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .brand-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            margin-bottom: 20px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .brand-title {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .brand-tagline {
            font-size: 18px;
            opacity: 0.9;
            font-weight: 300;
            letter-spacing: 2px;
        }

        .brand-decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .decoration1 {
            top: -100px;
            right: -100px;
        }

        .decoration2 {
            bottom: -100px;
            left: -100px;
        }

        /* Right Side - Form */
        .login-form {
            padding: 60px 50px;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 32px;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #22c55e;
            background: white;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
        }

        .remember-me label {
            color: #6b7280;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.5);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 12px 16px;
            border-radius: 8px;
            margin-top: 20px;
            animation: shake 0.5s ease;
        }

        .error-message ul {
            list-style: none;
            margin: 0;
        }

        .error-message li {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .error-message li:last-child {
            margin-bottom: 0;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-10px);
            }

            75% {
                transform: translateX(10px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            .login-container {
                grid-template-columns: 1fr;
                max-width: 100%;
                width: 100%;
            }

            .login-brand {
                padding: 30px 20px;
            }

            .brand-icon {
                width: 80px;
                height: 80px;
                font-size: 40px;
                margin-bottom: 15px;
            }

            .brand-title {
                font-size: 28px;
            }

            .brand-tagline {
                font-size: 14px;
            }

            .login-form {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 24px;
            }

            .form-header p {
                font-size: 13px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .input-wrapper input {
                padding: 12px 14px;
                font-size: 14px;
            }

            .btn-login {
                padding: 14px;
                font-size: 15px;
            }

            .mountain {
                height: 30%;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .login-brand {
                padding: 25px 15px;
            }

            .brand-icon {
                width: 70px;
                height: 70px;
                font-size: 35px;
            }

            .brand-title {
                font-size: 24px;
            }

            .brand-tagline {
                font-size: 12px;
                letter-spacing: 1px;
            }

            .login-form {
                padding: 25px 15px;
            }

            .form-header h2 {
                font-size: 22px;
            }

            .error-message {
                padding: 10px 12px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <!-- Background Decorations -->
    <div class="mountain"></div>
    <div class="cloud cloud1"></div>
    <div class="cloud cloud2"></div>
    <div class="cloud cloud3"></div>

    <!-- Login Container -->
    <div class="login-container">
        <!-- Left Side - Branding -->
        <div class="login-brand">
            <div class="brand-decoration decoration1"></div>
            <div class="brand-decoration decoration2"></div>

            <div class="brand-icon">
                🏡
            </div>
            <div class="brand-title">DesaBisa</div>
            <div class="brand-tagline">KEMBALI KE DESA</div>
        </div>

        <!-- Right Side - Form -->
        <div class="login-form">
            <div class="form-header">
                <h2>Selamat Datang</h2>
                <p>Silakan login untuk melanjutkan</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label>Email atau Username</label>
                    <div class="input-wrapper">
                        <input type="text" name="login" required autofocus
                            placeholder="Masukkan email atau username">
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" required placeholder="Masukkan password">
                    </div>
                </div>

                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">Masuk</button>

                @if ($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>

</html>
