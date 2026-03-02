<!DOCTYPE html>
<html>
<head>
    <title>Создать диалог</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .create-container {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 30px 25px;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
            margin: 0 auto;
            animation: fadeIn 0.6s ease-out;
        }

        .back-btn {
            background: #f0f0f0;
            padding: 10px 20px;
            border-radius: 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            position: absolute;
            left: 0;
            transition: all 0.3s ease;
            animation: fadeInLeft 0.5s ease-out;
        }

        .back-btn:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-group {
            margin-bottom: 25px;
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 16px;
        }

        .form-group select {
            width: 100%;
            padding: 15px 45px 15px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
            appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 18px;
            cursor: pointer;
        }

        .form-group select:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group select:disabled {
            background: #f5f5f5;
            color: #333;
            cursor: not-allowed;
            border-color: #e0e0e0;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
        }

        .form-group select:disabled:hover {
            transform: none;
            box-shadow: none;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            animation: shake 0.5s ease-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .topic-preview {
            position: relative;
            border-radius: 15px;
            margin-bottom: 25px;
            color: white;
            overflow: hidden;
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .topic-preview-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            transition: transform 0.5s ease;
        }

        .topic-preview:hover .topic-preview-background {
            transform: scale(1.05);
        }

        .topic-preview-overlay {
            position: relative;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            padding: 30px;
            text-align: center;
            z-index: 2;
            backdrop-filter: blur(2px);
            transition: all 0.3s ease;
        }

        .topic-preview:hover .topic-preview-overlay {
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(3px);
        }

        .topic-icon {
            font-size: 48px;
            margin-bottom: 10px;
            animation: bounceIn 0.6s ease-out;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.1);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }

        .topic-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            animation: slideInUp 0.5s ease-out 0.2s both;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .create-container {
                padding: 20px 15px;
            }

            .header h1 {
                font-size: 22px;
            }

            .back-btn {
                padding: 8px 15px;
                font-size: 14px;
            }

            .form-group select,
            .form-group input,
            .submit-btn {
                padding: 12px;
                font-size: 14px;
            }

            .form-group select {
                padding: 12px 40px 12px 12px;
                background-position: right 12px center;
                background-size: 16px;
            }

            .topic-preview-overlay {
                padding: 20px;
            }

            .topic-icon {
                font-size: 36px;
            }

            .topic-name {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="create-container">
        <div class="header">
            <a href="{{ route('topics.index') }}" class="back-btn">← Назад</a>
            <h1>Создать диалог</h1>
        </div>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        @php
            $imageName = 'путешествие';
            if (str_contains($preselectedTopic, 'кафе') || str_contains($preselectedTopic, 'Кафе')) {
                $imageName = 'кафе';
            } elseif (str_contains($preselectedTopic, 'путешествие') || str_contains($preselectedTopic, 'Путешествие')) {
                $imageName = 'путешествие';
            } elseif (str_contains($preselectedTopic, 'аптека') || str_contains($preselectedTopic, 'Аптека')) {
                $imageName = 'Аптека';
            } elseif (str_contains($preselectedTopic, 'зубной') || str_contains($preselectedTopic, 'Зубной')) {
                $imageName = 'зубной';
            } elseif (str_contains($preselectedTopic, 'парикмахер') || str_contains($preselectedTopic, 'Парикмахерская')) {
                $imageName = 'парикмахерская';
            } elseif (str_contains($preselectedTopic, 'спортзал') || str_contains($preselectedTopic, 'Спортзал') || str_contains($preselectedTopic, 'качалка')) {
                $imageName = 'качалка';
            } elseif (str_contains($preselectedTopic, 'Бронь') || str_contains($preselectedTopic, 'отеля')) {
                $imageName = 'Бронь';
            }
        @endphp

        @if($preselectedTopic)
            <div class="topic-preview">
                <div class="topic-preview-background" style="background-image: url('/images/{{ $imageName }}.jpg');"></div>
                <div class="topic-preview-overlay">
                    <div class="topic-icon">
                        @if(str_contains($preselectedTopic, 'кафе') || str_contains($preselectedTopic, 'Кафе')) ☕
                        @elseif(str_contains($preselectedTopic, 'путешествие') || str_contains($preselectedTopic, 'Путешествие')) ✈️
                        @elseif(str_contains($preselectedTopic, 'аптека') || str_contains($preselectedTopic, 'Аптека')) 💊
                        @elseif(str_contains($preselectedTopic, 'зубной') || str_contains($preselectedTopic, 'Зубной')) 🦷
                        @elseif(str_contains($preselectedTopic, 'парикмахер') || str_contains($preselectedTopic, 'Парикмахерская')) 💇
                        @elseif(str_contains($preselectedTopic, 'спортзал') || str_contains($preselectedTopic, 'Спортзал') || str_contains($preselectedTopic, 'качалка')) 💪
                        @elseif(str_contains($preselectedTopic, 'Бронь') || str_contains($preselectedTopic, 'отеля')) 🏨
                        @else 📝
                        @endif
                    </div>
                    <div class="topic-name">{{ $preselectedTopic }}</div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('dialogs.store') }}">
            @csrf
            
            @if(!$preselectedTopic)
            <div class="form-group">
                <label>Тема диалога:</label>
                <select name="topic" required>
                    <option value="">Выберите тему</option>
                    <option value="Путешествие">✈️ Путешествие (Средний)</option>
                    <option value="Кафе">☕ Кафе (Начинающий)</option>
                    <option value="Аптека">💊 Аптека (Средний)</option>
                    <option value="Зубной">🦷 Зубной (Продвинутый)</option>
                    <option value="Парикмахерская">💇 Парикмахерская (Начинающий)</option>
                    <option value="Спортзал">💪 Спортзал (Средний)</option>
                    <option value="Бронирование отеля">🏨 Бронирование отеля (Средний)</option>
                </select>
            </div>
            @else
                <input type="hidden" name="topic" value="{{ $preselectedTopic }}">
            @endif

            <div class="form-group">
                <label>Выберите студента:</label>
                <select name="student_id" required>
                    <option value="">Выберите студента</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="submit-btn">Создать диалог</button>
        </form>
    </div>
</body>
</html>