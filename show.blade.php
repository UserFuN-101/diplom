<!DOCTYPE html>
<html>
<head>
    <title>Диалог: {{ $dialog->topic }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        }

        .chat-wrapper {
            max-width: 1200px;
            width: 95%;
            margin: 0 auto;
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .chat-header {
            padding: 25px 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .back-link {
            background: #f0f0f0;
            padding: 10px 20px;
            border-radius: 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }

        .back-link:hover {
            background: #e0e0e0;
        }

        .dialog-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dialog-info h2 {
            color: #333;
            font-size: 28px;
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-waiting {
            background: #ffc107;
            color: #333;
        }

        .status-active {
            background: #28a745;
            color: white;
        }

        .status-finished {
            background: #6c757d;
            color: white;
        }

        .participants {
            margin-top: 10px;
            color: #666;
            font-size: 15px;
        }

        .goals-section {
            padding: 25px 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
        }

        .goals-section h3 {
            margin-bottom: 15px;
            color: #333;
            font-size: 20px;
        }

        .goals-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .goal-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: white;
            border-radius: 12px;
            border-left: 4px solid;
            font-size: 15px;
        }

        .goal-checkbox {
            width: 22px;
            height: 22px;
            cursor: pointer;
        }

        .goal-text {
            flex: 1;
        }

        .goal-completed {
            text-decoration: line-through;
            color: #888;
        }

        .complete-btn-container {
            display: flex;
            justify-content: center;
            margin: 30px 0;
        }

        .complete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 12px 40px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 2px 5px rgba(220, 53, 69, 0.2);
        }

        .complete-btn:hover {
            background: #c82333;
        }

        .chat-container {
            height: 500px;
            overflow-y: auto;
            padding: 30px;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 20px;
            max-width: 70%;
        }

        .my-message {
            margin-left: auto;
        }

        .message-content {
            padding: 15px 20px;
            border-radius: 20px;
            word-wrap: break-word;
            font-size: 15px;
            line-height: 1.5;
        }

        .my-message .message-content {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .other-message .message-content {
            background: #e9ecef;
            color: #333;
            border-bottom-left-radius: 5px;
        }

        .message-info {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
            margin-left: 10px;
        }

        .my-message .message-info {
            text-align: right;
            margin-right: 10px;
        }

        .chat-footer {
            padding: 25px 30px;
            background: white;
            border-top: 1px solid #e0e0e0;
        }

        .chat-form {
            display: flex;
            gap: 15px;
        }

        .chat-form input {
            flex: 1;
            padding: 18px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 30px;
            font-size: 16px;
            transition: border-color 0.2s;
        }

        .chat-form input:focus {
            outline: none;
            border-color: #667eea;
        }

        .chat-form button {
            padding: 18px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .chat-form button:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46a0 100%);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal-content {
            background: white;
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            border-radius: 20px;
        }

        .modal-content h3 {
            margin-bottom: 20px;
            color: #333;
            font-size: 22px;
        }

        .modal-content select {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
        }

        .modal-buttons button {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .modal-buttons .confirm {
            background: #28a745;
            color: white;
        }

        .modal-buttons .confirm:hover {
            background: #218838;
        }

        .modal-buttons .cancel {
            background: #6c757d;
            color: white;
        }

        .modal-buttons .cancel:hover {
            background: #5a6268;
        }

        .empty-chat {
            text-align: center;
            color: #999;
            padding: 80px;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .chat-wrapper {
                width: 100%;
                padding: 0;
            }
            
            .chat-form {
                flex-direction: column;
            }
            
            .message {
                max-width: 85%;
            }
            
            .dialog-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="chat-wrapper">
        <div class="chat-header">
            <div class="header-top">
                <a href="{{ route('dashboard') }}" class="back-link">← Назад</a>
            </div>
            
            <div class="dialog-info">
                <h2>{{ $dialog->topic }}</h2>
                <span class="status-badge status-{{ $dialog->status }}">
                    @if($dialog->status == 'waiting') Ожидание
                    @elseif($dialog->status == 'active') Активен
                    @else Завершён
                    @endif
                </span>
            </div>
            
            <div class="participants">
                <span>Преподаватель: {{ $dialog->teacher->name }}</span>
                <span style="margin-left: 20px;">Студент: {{ $dialog->student->name }}</span>
            </div>
        </div>

        <div class="goals-section">
            <h3>🎯 Цели диалога</h3>
            <div class="goals-list">
                @forelse($dialog->goals as $goal)
                    <div class="goal-item" style="border-left-color: {{ $goal->is_completed ? '#28a745' : '#ffc107' }};">
                        @if(Auth::user()->role == 'teacher' && $dialog->status != 'finished')
                            <input type="checkbox" 
                                   class="goal-checkbox" 
                                   data-goal-id="{{ $goal->id }}"
                                   {{ $goal->is_completed ? 'checked' : '' }}>
                        @else
                            <span style="width: 22px; height: 22px; display: inline-block; border-radius: 4px; background: {{ $goal->is_completed ? '#28a745' : '#ffc107' }};"></span>
                        @endif
                        <span class="goal-text {{ $goal->is_completed ? 'goal-completed' : '' }}">
                            {{ $goal->description }}
                        </span>
                    </div>
                @empty
                    <p style="color: #999; text-align: center;">Цели пока не добавлены</p>
                @endforelse
            </div>
        </div>

        @if(Auth::user()->role == 'teacher' && $dialog->status != 'finished')
            <div class="complete-btn-container">
                <button onclick="showGradeModal()" class="complete-btn">
                    Завершить диалог
                </button>
            </div>
        @endif

        <div class="chat-container" id="chat">
            @forelse($dialog->messages as $message)
                <div class="message {{ $message->user_id == Auth::id() ? 'my-message' : 'other-message' }}">
                    <div class="message-info">{{ $message->user->name }}</div>
                    <div class="message-content">{{ $message->text }}</div>
                </div>
            @empty
                <div class="empty-chat">
                    Нет сообщений. Начните общение!
                </div>
            @endforelse
        </div>

        <div class="chat-footer">
            @if($dialog->status != 'finished')
                <form class="chat-form" id="messageForm">
                    @csrf
                    <input type="text" id="messageInput" placeholder="Введите сообщение..." required autofocus>
                    <button type="submit">Отправить</button>
                </form>
            @else
                <div style="text-align: center; color: #666; font-size: 16px;">
                    Диалог завершён. Отправка сообщений недоступна.
                </div>
            @endif
        </div>
    </div>

    {{-- Модальное окно для оценки --}}
    <div id="gradeModal" class="modal">
        <div class="modal-content">
            <h3>Выставить оценку</h3>
            <select id="grade">
                <option value="5">5 - Отлично</option>
                <option value="4">4 - Хорошо</option>
                <option value="3">3 - Удовлетворительно</option>
                <option value="2">2 - Неудовлетворительно</option>
                <option value="1">1 - Плохо</option>
            </select>
            <div class="modal-buttons">
                <button class="confirm" onclick="completeDialog()">Подтвердить</button>
                <button class="cancel" onclick="closeGradeModal()">Отмена</button>
            </div>
        </div>
    </div>

    <script>
        const dialogId = {{ $dialog->id }};
        const userId = {{ Auth::id() }};
        const chatContainer = document.getElementById('chat');

        // Отметка выполнения цели
        document.querySelectorAll('.goal-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const goalId = this.dataset.goalId;
                const completed = this.checked;
                
                fetch(`/goals/${goalId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ completed: completed })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const goalItem = this.closest('.goal-item');
                        const goalText = goalItem.querySelector('.goal-text');
                        if (completed) {
                            goalText.classList.add('goal-completed');
                            goalItem.style.borderLeftColor = '#28a745';
                        } else {
                            goalText.classList.remove('goal-completed');
                            goalItem.style.borderLeftColor = '#ffc107';
                        }
                    }
                });
            });
        });

        // Отправка сообщения
        const messageForm = document.getElementById('messageForm');
        if (messageForm) {
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const input = document.getElementById('messageInput');
                const text = input.value.trim();
                
                if (!text) return;
                
                fetch(`/dialogs/${dialogId}/messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ text: text })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        input.value = '';
                        
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'message my-message';
                        messageDiv.innerHTML = `
                            <div class="message-info">{{ Auth::user()->name }}</div>
                            <div class="message-content">${data.message.text}</div>
                        `;
                        chatContainer.appendChild(messageDiv);
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                        
                        const emptyChat = document.querySelector('.empty-chat');
                        if (emptyChat) emptyChat.remove();
                    }
                });
            });
        }

        // Прокрутка вниз при загрузке
        chatContainer.scrollTop = chatContainer.scrollHeight;

        // Функции для модального окна
        function showGradeModal() {
            document.getElementById('gradeModal').style.display = 'block';
        }
        
        function closeGradeModal() {
            document.getElementById('gradeModal').style.display = 'none';
        }
        
        function completeDialog() {
            const grade = document.getElementById('grade').value;
            
            fetch(`/dialogs/${dialogId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ grade: grade })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Ошибка при завершении диалога: ' + JSON.stringify(data));
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при завершении диалога');
            });
        }
    </script>
</body>
</html>