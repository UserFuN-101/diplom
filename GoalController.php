<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DialogGoal;
use App\Models\Dialog;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * Переключить статус выполнения цели
     */
    public function toggle(Request $request, $id)
    {
        $goal = DialogGoal::findOrFail($id);
        $dialog = $goal->dialog;
        
        // Проверка прав (только преподаватель может отмечать цели)
        if ($dialog->teacher_id != Auth::id()) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        // Нельзя менять цели в завершённом диалоге
        if ($dialog->status == 'finished') {
            return response()->json(['error' => 'Диалог уже завершён'], 403);
        }

        $goal->is_completed = $request->completed;
        $goal->save();

        return response()->json(['success' => true]);
    }

    /**
     * Удалить цель
     */
    public function destroy($id)
    {
        $goal = DialogGoal::findOrFail($id);
        $dialog = $goal->dialog;
        
        if ($dialog->teacher_id != Auth::id()) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        // Нельзя удалять стандартные цели
        if ($goal->is_default) {
            return response()->json(['error' => 'Нельзя удалить стандартную цель'], 403);
        }

        $goal->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Добавить новую цель
     */
    public function store(Request $request, $dialogId)
    {
        $request->validate([
            'description' => 'required|string|max:255'
        ]);

        $dialog = Dialog::findOrFail($dialogId);
        
        if ($dialog->teacher_id != Auth::id()) {
            return redirect()->back()->with('error', 'Доступ запрещен');
        }

        // Нельзя добавлять цели в завершённый диалог
        if ($dialog->status == 'finished') {
            return redirect()->back()->with('error', 'Диалог уже завершён');
        }

        $maxOrder = $dialog->goals()->max('order') ?? 0;

        DialogGoal::create([
            'dialog_id' => $dialogId,
            'description' => $request->description,
            'is_default' => false,
            'is_completed' => false,
            'order' => $maxOrder + 1
        ]);

        return redirect()->back()->with('success', 'Цель добавлена');
    }
}