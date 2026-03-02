<!DOCTYPE html>
<html>
<head>
    <title>Темы для диалогов</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        }

        .topics-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 30px 25px;
            backdrop-filter: blur(5px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
        }

        .back-btn {
            background: #f0f0f0;
            padding: 10px 20px;
            border-radius: 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .topics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .topic-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .topic-card:hover {
            transform: translateY(-5px);
        }

        .topic-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            transition: transform 0.5s ease;
        }

        .topic-card:hover .topic-image {
            transform: scale(1.05);
        }

        .topic-overlay {
            position: relative;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.3), transparent);
            padding: 25px 20px 20px;
            color: white;
            z-index: 2;
            margin-top: auto;
        }

        .topic-icon {
            font-size: 32px;
            margin-bottom: 10px;
            display: inline-block;
            background: rgba(255,255,255,0.2);
            width: 50px;
            height: 50px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }

        .topic-name {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .topic-level {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .topic-description {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .card-buttons {
            display: flex;
            gap: 10px;
        }

        .start-btn {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .start-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .favorite-btn {
            flex: 1;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 10px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(5px);
        }

        .favorite-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .topics-grid {
                grid-template-columns: 1fr;
            }
            
            .topics-container {
                padding: 20px 15px;
            }
            
            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="topics-container">
        <div class="header">
            <h1>📚 Темы для диалогов</h1>
            <a href="{{ route('dashboard') }}" class="back-btn">← Назад</a>
        </div>

        <div class="topics-grid">
            {{-- Путешествие --}}
            <div class="topic-card">
                <div class="topic-image" style="background-image: url('/images/путешествие.jpg');"></div>
                <div class="topic-overlay">
                    <div class="topic-icon">✈️</div>
                    <div class="topic-name">Путешествие</div>
                    <div class="topic-level">Уровень: Средний</div>
                    <div class="topic-description">Бронирование отелей, авиабилетов, общение в аэропорту</div>
                    @if(Auth::user()->role == 'teacher')
                        <button class="start-btn" onclick="window.location.href='{{ route('dialogs.create', ['topic' => 'Путешествие']) }}'">
                            Начать диалог
                        </button>
                    @else
                        <div class="card-buttons">
                            <button class="favorite-btn" onclick="addToFavorites('Путешествие')">
                                ★ В избранное
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Кафе --}}
            <div class="topic-card">
                <div class="topic-image" style="background-image: url('/images/кафе.jpg');"></div>
                <div class="topic-overlay">
                    <div class="topic-icon">☕</div>
                    <div class="topic-name">Кафе</div>
                    <div class="topic-level">Уровень: Начинающий</div>
                    <div class="topic-description">Заказ еды и напитков, общение с официантом</div>
                    @if(Auth::user()->role == 'teacher')
                        <button class="start-btn" onclick="window.location.href='{{ route('dialogs.create', ['topic' => 'Кафе']) }}'">
                            Начать диалог
                        </button>
                    @else
                        <div class="card-buttons">
                            <button class="favorite-btn" onclick="addToFavorites('Кафе')">
                                ★ В избранное
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Аптека --}}
            <div class="topic-card">
                <div class="topic-image" style="background-image: url('/images/Аптека.jpg');"></div>
                <div class="topic-overlay">
                    <div class="topic-icon">💊</div>
                    <div class="topic-name">Аптека</div>
                    <div class="topic-level">Уровень: Средний</div>
                    <div class="topic-description">Покупка лекарств, описание симптомов</div>
                    @if(Auth::user()->role == 'teacher')
                        <button class="start-btn" onclick="window.location.href='{{ route('dialogs.create', ['topic' => 'Аптека']) }}'">
                            Начать диалог
                        </button>
                    @else
                        <div class="card-buttons">
                            <button class="favorite-btn" onclick="addToFavorites('Аптека')">
                                ★ В избранное
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Зубной --}}
            <div class="topic-card">
                <div class="topic-image" style="background-image: url('/images/зубной.jpg');"></div>
                <div class="topic-overlay">
                    <div class="topic-icon">🦷</div>
                    <div class="topic-name">Зубной</div>
                    <div class="topic-level">Уровень: Продвинутый</div>
                    <div class="topic-description">Запись к врачу, описание зубной боли</div>
                    @if(Auth::user()->role == 'teacher')
                        <button class="start-btn" onclick="window.location.href='{{ route('dialogs.create', ['topic' => 'Зубной']) }}'">
                            Начать диалог
                        </button>
                    @else
                        <div class="card-buttons">
                            <button class="favorite-btn" onclick="addToFavorites('Зубной')">
                                ★ В избранное
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Парикмахерская --}}
            <div class="topic-card">
                <div class="topic-image" style="background-image: url('/images/парикмахерская.jpg');"></div>
                <div class="topic-overlay">
                    <div class="topic-icon">💇</div>
                    <div class="topic-name">Парикмахерская</div>
                    <div class="topic-level">Уровень: Начинающий</div>
                    <div class="topic-description">Запись на стрижку, описание желаемой прически</div>
                    @if(Auth::user()->role == 'teacher')
                        <button class="start-btn" onclick="window.location.href='{{ route('dialogs.create', ['topic' => 'Парикмахерская']) }}'">
                            Начать диалог
                        </button>
                    @else
                        <div class="card-buttons">
                            <button class="favorite-btn" onclick="addToFavorites('Парикмахерская')">
                                ★ В избранное
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Качалка (Спортзал) --}}
            <div class="topic-card">
                <div class="topic-image" style="background-image: url('/images/качалка.jpg');"></div>
                <div class="topic-overlay">
                    <div class="topic-icon">💪</div>
                    <div class="topic-name">Спортзал</div>
                    <div class="topic-level">Уровень: Средний</div>
                    <div class="topic-description">Запись в зал, общение с тренером</div>
                    @if(Auth::user()->role == 'teacher')
                        <button class="start-btn" onclick="window.location.href='{{ route('dialogs.create', ['topic' => 'Спортзал']) }}'">
                            Начать диалог
                        </button>
                    @else
                        <div class="card-buttons">
                            <button class="favorite-btn" onclick="addToFavorites('Спортзал')">
                                ★ В избранное
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Бронь (Отель) --}}
            <div class="topic-card">
                <div class="topic-image" style="background-image: url('/images/Бронь.jpg');"></div>
                <div class="topic-overlay">
                    <div class="topic-icon">🏨</div>
                    <div class="topic-name">Бронирование отеля</div>
                    <div class="topic-level">Уровень: Средний</div>
                    <div class="topic-description">Бронь номера, дополнительные услуги</div>
                    @if(Auth::user()->role == 'teacher')
                        <button class="start-btn" onclick="window.location.href='{{ route('dialogs.create', ['topic' => 'Бронирование отеля']) }}'">
                            Начать диалог
                        </button>
                    @else
                        <div class="card-buttons">
                            <button class="favorite-btn" onclick="addToFavorites('Бронирование отеля')">
                                ★ В избранное
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function addToFavorites(topic) {
            fetch('/favorites/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ topic: topic })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Тема добавлена в избранное!');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при добавлении в избранное');
            });
        }
    </script>
</body>
</html>