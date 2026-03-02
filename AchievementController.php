<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dialog;
use App\Models\User;
use App\Models\Message;

class AchievementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Подсчёт реальных данных пользователя
        $dialogsCount = Dialog::where('student_id', $user->id)->count();
        $finishedDialogs = Dialog::where('student_id', $user->id)
                               ->where('status', 'finished')
                               ->count();
        
        $messagesCount = Message::whereIn('dialog_id', 
            Dialog::where('student_id', $user->id)->pluck('id')
        )->count();

        // Достижения с реальными условиями
        $achievements = [
            [
                'name' => 'Первый диалог',
                'description' => 'Начать первый диалог с преподавателем',
                'icon' => '🎯',
                'xp' => 50,
                'unlocked' => $dialogsCount >= 1,
                'date' => $dialogsCount >= 1 ? now()->format('d.m.Y') : null
            ],
            [
                'name' => 'Активный ученик',
                'description' => 'Провести 5 диалогов',
                'icon' => '📚',
                'xp' => 100,
                'unlocked' => $dialogsCount >= 5,
                'date' => $dialogsCount >= 5 ? now()->format('d.m.Y') : null
            ],
            [
                'name' => 'Опытный говорящий',
                'description' => 'Провести 10 диалогов',
                'icon' => '🏆',
                'xp' => 200,
                'unlocked' => $dialogsCount >= 10,
                'date' => $dialogsCount >= 10 ? now()->format('d.m.Y') : null
            ],
            [
                'name' => 'Завершитель',
                'description' => 'Завершить 3 диалога',
                'icon' => '✅',
                'xp' => 75,
                'unlocked' => $finishedDialogs >= 3,
                'date' => $finishedDialogs >= 3 ? now()->format('d.m.Y') : null
            ],
            [
                'name' => 'Болтун',
                'description' => 'Отправить 50 сообщений',
                'icon' => '💬',
                'xp' => 150,
                'unlocked' => $messagesCount >= 50,
                'date' => $messagesCount >= 50 ? now()->format('d.m.Y') : null
            ],
        ];

        // Подсчёт статистики
        $totalAchievements = count($achievements);
        $unlockedCount = 0;
        $totalXp = 0;
        
        foreach ($achievements as $ach) {
            if ($ach['unlocked']) {
                $unlockedCount++;
                $totalXp += $ach['xp'];
            }
        }
        
        $progressPercent = ($unlockedCount / $totalAchievements) * 100;

        // Обновляем XP пользователя в БД
        $user->xp = $totalXp;
        $user->level = floor($totalXp / 100) + 1; // 1 уровень за каждые 100 XP
        $user->save();

        return view('achievements.index', compact(
            'achievements', 
            'totalXp', 
            'unlockedCount', 
            'totalAchievements', 
            'progressPercent'
        ));
    }
}