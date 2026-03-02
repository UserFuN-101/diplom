<!DOCTYPE html>
<html>
<head>
    <title>Главная</title>
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
            padding: 20px;
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
            background: url('/images/fon2.jpg') no-repeat center center fixed;
            background-size: cover;
            filter: blur(5px);
            transform: scale(1.1);
            z-index: -1;
        }

        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            border-bottom: 1px solid rgba(224, 224, 224, 0.5);
        }

        .user-info h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #333;
            text-align: left;
        }

        .user-info p {
            color: #666;
            font-size: 14px;
            text-align: left;
        }

        .level {
            background: rgba(240, 240, 240, 0.9);
            color: #333;
            padding: 10px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .main-content {
            display: flex;
            padding: 30px;
            gap: 30px;
        }

        .left-column {
            flex: 1;
            max-width: 400px;
        }

        .right-column {
            flex: 2;
            background: rgba(248, 249, 250, 0.8);
            border-radius: 20px;
            padding: 20px;
            min-height: 400px;
            backdrop-filter: blur(2px);
        }

        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: rgba(248, 249, 250, 0.8);
            padding: 20px;
            border-radius: 20px;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(2px);
        }

        .stat-card:hover {
            background: rgba(240, 240, 240, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .stat-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .stat-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }

        .topics-button {
            margin-bottom: 20px;
        }

        .topics-button button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .topics-button button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .logout-btn {
            width: 100%;
            padding: 15px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            display: inline-block;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .right-column h3 {
            margin-bottom: 20px;
            color: #333;
            font-size: 20px;
            text-align: left;
        }

        .dialogs-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .dialog-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(2px);
        }

        .dialog-item:hover {
            background: rgba(240, 240, 240, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .dialog-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .dialog-icon {
            font-size: 24px;
        }

        .dialog-title {
            font-weight: 600;
            color: #333;
        }

        .dialog-meta {
            font-size: 12px;
            color: #666;
        }

        .dialog-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .dialog-grade {
            background: #28a745;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .new-badge {
            background: #ff4757;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .arrow {
            color: #666;
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }
            
            .left-column {
                max-width: 100%;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .user-info h1,
            .user-info p {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    @php
        $user = Auth::user();
        
        $activeDialogsCount = \App\Models\Dialog::where(function($q) use ($user) {
            $q->where('student_id', $user->id)
              ->orWhere('teacher_id', $user->id);
        })->whereIn('status', ['waiting', 'active'])->count();
        
        $recentDialogs = \App\Models\Dialog::where(function($q) use ($user) {
            $q->where('student_id', $user->id)
              ->orWhere('teacher_id', $user->id);
        })->with(['student', 'teacher'])
          ->orderBy('created_at', 'desc')
          ->take(5)
          ->get();
    @endphp

    <div class="dashboard">
        {{-- Шапка профиля --}}
        <div class="header">
            <div class="user-info">
                <h1>{{ $user->name }}</h1>
                <p>{{ $user->email }}</p>
            </div>
            <div class="level">
                <span>Уровень {{ $user->level ?? 1 }}</span>
                <span>|</span>
                <span>{{ $user->xp ?? 0 }} XP</span>
            </div>
        </div>

        {{-- Основной контент с двумя колонками --}}
        <div class="main-content">
            {{-- Левая колонка --}}
            <div class="left-column">
                {{-- Статистика --}}
                <div class="stats">
                    <div class="stat-card" onclick="window.location.href='{{ route('achievements.index') }}'">
                        <div class="stat-icon">🏆</div>
                        <div class="stat-title">Мои достижения</div>
                        <div class="stat-value">{{ $achievementsCount ?? 0 }}</div>
                    </div>
                    <div class="stat-card" onclick="window.location.href='{{ route('dialogs.index') }}'">
                        <div class="stat-icon">💬</div>
                        <div class="stat-title">Активные диалоги</div>
                        <div class="stat-value">{{ $activeDialogsCount }}</div>
                    </div>
                </div>

                {{-- Кнопка просмотра тем --}}
                <div class="topics-button">
                    <button onclick="window.location.href='{{ route('topics.index') }}'">
                        Просмотр тем для диалога
                    </button>
                </div>

                {{-- Кнопка выхода --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Выйти
                    </button>
                </form>
            </div>

            {{-- Правая колонка --}}
            <div class="right-column">
                <h3>Последние диалоги</h3>
                
                <div class="dialogs-list">
                    @forelse($recentDialogs as $dialog)
                        <div class="dialog-item" onclick="window.location.href='{{ route('dialogs.show', $dialog->id) }}'">
                            <div class="dialog-info">
                                <span class="dialog-icon">
                                    @if(str_contains($dialog->topic, 'кафе')) ☕
                                    @elseif(str_contains($dialog->topic, 'аэропорт')) ✈️
                                    @elseif(str_contains($dialog->topic, 'отдых')) 🏖️
                                    @elseif(str_contains($dialog->topic, 'собеседование')) 💼
                                    @elseif(str_contains($dialog->topic, 'гостиница')) 🏨
                                    @elseif(str_contains($dialog->topic, 'магазин')) 🛒
                                    @else 📝
                                    @endif
                                </span>
                                <div>
                                    <div class="dialog-title">{{ $dialog->topic }}</div>
                                    <div class="dialog-meta">
                                        @if($user->id == $dialog->teacher_id)
                                            с {{ $dialog->student->name }}
                                        @else
                                            с {{ $dialog->teacher->name }}
                                        @endif
                                        | {{ $dialog->created_at->format('d.m.Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="dialog-right">
                                @if($dialog->status == 'finished' && $dialog->final_grade)
                                    <span class="dialog-grade">{{ $dialog->final_grade }}/5</span>
                                @elseif($dialog->status == 'waiting')
                                    <span class="new-badge">Новый</span>
                                @elseif($dialog->status == 'active')
                                    <span style="color: #28a745;">🟢</span>
                                @endif
                                <span class="arrow">▶</span>
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; color: #666; padding: 20px;">У вас пока нет диалогов</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>
</html>