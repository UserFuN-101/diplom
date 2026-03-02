<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dialog;
use App\Models\User;
use App\Models\DialogGoal;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class DialogController extends Controller
{
    /**
     * Показать список активных диалогов
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role == 'teacher') {
            $dialogs = Dialog::where('teacher_id', $user->id)
                            ->whereIn('status', ['waiting', 'active'])
                            ->with('student')
                            ->orderBy('created_at', 'desc')
                            ->get();
        } else {
            $dialogs = Dialog::where('student_id', $user->id)
                            ->whereIn('status', ['waiting', 'active'])
                            ->with('teacher')
                            ->orderBy('created_at', 'desc')
                            ->get();
        }
        
        return view('dialogs.index', compact('dialogs'));
    }

    /**
     * Показать форму создания диалога
     */
    public function create(Request $request)
    {
        if (Auth::user()->role != 'teacher') {
            return redirect()->route('dashboard')->with('error', 'Только преподаватели могут создавать диалоги');
        }

        $students = User::where('role', 'student')->get();
        $preselectedTopic = $request->query('topic', '');
        
        return view('dialogs.create', compact('students', 'preselectedTopic'));
    }

    /**
     * Сохранить новый диалог
     */
    public function store(Request $request)
    {
        if (Auth::user()->role != 'teacher') {
            return redirect()->route('dashboard')->with('error', 'Только преподаватели могут создавать диалоги');
        }

        $request->validate([
            'topic' => 'required|string|max:255',
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::find($request->student_id);
        if ($student->role != 'student') {
            return back()->with('error', 'Можно выбрать только студента');
        }

        $dialog = Dialog::create([
            'topic' => $request->topic,
            'student_id' => $request->student_id,
            'teacher_id' => Auth::id(),
            'status' => 'waiting',
        ]);

        $defaultGoals = $this->getDefaultGoals($request->topic);
        foreach ($defaultGoals as $index => $goal) {
            DialogGoal::create([
                'dialog_id' => $dialog->id,
                'description' => $goal,
                'is_default' => true,
                'order' => $index
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Диалог успешно создан');
    }

    /**
     * Показать конкретный диалог
     */
    public function show($id)
    {
        $dialog = Dialog::with(['messages.user', 'student', 'teacher', 'goals'])->findOrFail($id);
        
        if ($dialog->student_id != Auth::id() && $dialog->teacher_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'У вас нет доступа к этому диалогу');
        }

        return view('dialogs.show', compact('dialog'));
    }

    /**
     * Завершить диалог с оценкой
     */
    public function complete(Request $request, $id)
    {
        $dialog = Dialog::findOrFail($id);
        
        if ($dialog->teacher_id != Auth::id()) {
            return response()->json(['error' => 'Доступ запрещен'], 403);
        }

        $request->validate([
            'grade' => 'required|integer|min:1|max:5',
        ]);

        $dialog->status = 'finished';
        $dialog->final_grade = $request->grade;
        $dialog->save();

        return response()->json(['success' => true]);
    }

    /**
     * Отменить диалог (для студента)
     */
    public function cancel($id)
    {
        $dialog = Dialog::findOrFail($id);
        
        if ($dialog->student_id != Auth::id() || $dialog->status != 'waiting') {
            return redirect()->back()->with('error', 'Невозможно отменить этот диалог');
        }

        $dialog->delete();
        
        return redirect()->route('dashboard')->with('success', 'Диалог отклонён');
    }

    /**
     * Метод для стандартных целей
     */
    private function getDefaultGoals($topic)
    {
        $goals = [
            'Заказ в кафе' => [
                'Поприветствовать официанта',
                'Сделать заказ',
                'Использовать вежливую форму (please, thank you)',
                'Уточнить детали заказа',
                'Оплатить заказ'
            ],
            'В аэропорту' => [
                'Спросить путь к выходу',
                'Узнать информацию о рейсе',
                'Объяснить проблему с багажом',
                'Поблагодарить за помощь',
                'Попрощаться'
            ],
            'Собеседование' => [
                'Представиться',
                'Рассказать о своём опыте',
                'Ответить на вопросы работодателя',
                'Показать мотивацию',
                'Поблагодарить за собеседование'
            ],
            'В гостинице' => [
                'Забронировать номер',
                'Уточнить детали проживания',
                'Попросить дополнительные услуги',
                'Сообщить о проблеме',
                'Выселиться из отеля'
            ],
            'В магазине' => [
                'Попросить помощи у продавца',
                'Уточнить цену',
                'Примерить вещь',
                'Оплатить покупку',
                'Поблагодарить и попрощаться'
            ],
            'На отдыхе' => [
                'Спросить дорогу к пляжу',
                'Заказать напиток',
                'Познакомиться с кем-то',
                'Рассказать о своих планах',
                'Попрощаться'
            ]
        ];

        return $goals[$topic] ?? [
            'Основная цель диалога',
            'Использовать вежливые формы',
            'Уложиться в лимит сообщений'
        ];
    }
}