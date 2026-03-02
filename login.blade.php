<!DOCTYPE html>
<html>
<head>
    <title>Вход в систему</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: #667eea;
        }

        /* Фоновое изображение с блюром */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/images/fon1.jpg') no-repeat center center fixed;
            background-size: cover;
            filter: blur(5px);
            transform: scale(1.1);
            z-index: -1;
        }

        .auth-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            padding: 35px 25px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .auth-container h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 25px;
            text-align: center;
        }

        .auth-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .auth-container input {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 16px;
            transition: all 0.2s;
            background: white;
        }

        .auth-container input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .auth-container button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 10px;
        }

        .auth-container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .auth-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 15px;
        }

        .auth-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }

        .error {
            background: #fee;
            color: #c33;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid #fcc;
            font-size: 14px;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .auth-container {
                padding: 25px 18px;
            }

            .auth-container h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .auth-container input,
            .auth-container button {
                padding: 14px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Добро пожаловать!</h2>
        
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
        
        <div class="auth-link">
            Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
        </div>
    </div>
</body>
</html>