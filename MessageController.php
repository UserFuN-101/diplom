<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Dialog;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Сохранить новое сообщение
     */
    public function store(Request $request, $dialogId)
    {
        // Валидация
        $request->validate([
            'text' => 'required|string',
        ]);

        // Находим диалог
        $dialog = Dialog::findOrFail($dialogId);
        
        // Проверяем, что пользователь участвует в диалоге
        if ($dialog->student_id != Auth::id() && $dialog->teacher_id != Auth::id()) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        // Если диалог в статусе waiting, меняем на active
        if ($dialog->status == 'waiting') {
            $dialog->status = 'active';
            $dialog->save();
        }

        // Создаём сообщение
        $message = Message::create([
            'dialog_id' => $dialogId,
            'user_id' => Auth::id(),
            'text' => $request->text,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'text' => $message->text,
                'user_id' => $message->user_id,
                'user_name' => Auth::user()->name,
                'created_at' => $message->created_at->toDateTimeString(),
            ]
        ]);
    }
}