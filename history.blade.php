<!DOCTYPE html>
<html>
<head>
    <title>История диалогов</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .history-list { margin-top: 20px; }
        .history-item {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #6c757d;
        }
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .history-topic { font-size: 18px; font-weight: bold; color: #333; }
        .history-grade {
            background: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
        }
        .history-meta { color: #666; font-size: 14px; }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
        }
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #666;
            background: white;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <a href="{{ route('dashboard') }}" class="back-link">← Вернуться на главную</a>
        <h1>История завершённых диалогов</h1>

        <div class="history-list">
            @forelse($dialogs as $dialog)
                <div class="history-item">
                    <div class="history-header">
                        <span class="history-topic">{{ $dialog->topic }}</span>
                        <span class="history-grade">Оценка: {{ $dialog->final_grade }}/5</span>
                    </div>
                    <div class="history-meta">
                        @if(Auth::user()->role == 'teacher')
                            <strong>Студент:</strong> {{ $dialog->student->name }}<br>
                        @else
                            <strong>Преподаватель:</strong> {{ $dialog->teacher->name }}<br>
                        @endif
                        <strong>Дата:</strong> {{ $dialog->created_at->format('d.m.Y H:i') }}<br>
                        <strong>Сообщений:</strong> {{ $dialog->messages->count() }}
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <h3>История диалогов пуста</h3>
                    <p>Завершённые диалоги будут отображаться здесь</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>