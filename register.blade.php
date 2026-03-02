<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
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
            background: #667eea; /* запасной цвет */
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
            max-width: 450px;
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

        .auth-container input,
        .auth-container select {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 16px;
            transition: all 0.2s;
            background: white;
        }

        .auth-container input:focus,
        .auth-container select:focus {
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

        .radio-group {
            background: rgba(248, 249, 250, 0.9);
            padding: 18px;
            border-radius: 15px;
            margin: 5px 0;
        }

        .radio-group p {
            margin-bottom: 12px;
            font-weight: 600;
            color: #555;
            font-size: 15px;
        }

        .radio-group label {
            display: inline-flex;
            align-items: center;
            margin-right: 30px;
            cursor: pointer;
            color: #555;
            font-size: 15px;
        }

        .radio-group input[type="radio"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
        }

        #teacher-code-field {
            margin-top: 10px;
        }

        #teacher-code-field small {
            display: block;
            color: #666;
            margin-top: 5px;
            font-size: 13px;
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
            .auth-container select,
            .auth-container button {
                padding: 14px;
                font-size: 15px;
            }

            .radio-group {
                padding: 15px;
            }

            .radio-group label {
                display: flex;
                margin-right: 0;
                margin-bottom: 10px;
            }

            .radio-group label:last-child {
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Создать аккаунт</h2>
        
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Имя" value="{{ old('name') }}" required>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" placeholder="Пароль (минимум 6 символов)" required>
            <input type="password" name="password_confirmation" placeholder="Подтверждение пароля" required>
            
            <div class="radio-group">
                <p>Выберите роль:</p>
                <label>
                    <input type="radio" name="role" value="student" {{ old('role') == 'student' ? 'checked' : '' }} required> Студент
                </label>
                <label>
                    <input type="radio" name="role" value="teacher" {{ old('role') == 'teacher' ? 'checked' : '' }} required> Преподаватель
                </label>
            </div>

            <!-- Поле для кода преподавателя -->
            <div id="teacher-code-field" style="display: none;">
                <input type="text" name="teacher_code" placeholder="Код доступа для преподавателя" value="{{ old('teacher_code') }}">
                <small>Введите специальный код для регистрации как преподаватель</small>
            </div>

            <button type="submit">Зарегистрироваться</button>
        </form>
        
        <div class="auth-link">
            Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('input[name="role"]');
            const teacherCodeField = document.getElementById('teacher-code-field');
            
            function toggleTeacherCode() {
                const selectedRole = document.querySelector('input[name="role"]:checked');
                if (selectedRole && selectedRole.value === 'teacher') {
                    teacherCodeField.style.display = 'block';
                    document.querySelector('input[name="teacher_code"]').required = true;
                } else {
                    teacherCodeField.style.display = 'none';
                    document.querySelector('input[name="teacher_code"]').required = false;
                }
            }
            
            roleRadios.forEach(radio => {
                radio.addEventListener('change', toggleTeacherCode);
            });
            
            toggleTeacherCode();
        });
    </script>
</body>
</html>