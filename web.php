<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\DialogController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Главная страница - редирект на логин
Route::get('/', function () {
    return redirect('/login');
});

// Гостевые маршруты (только для неавторизованных)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Защищенные маршруты (только для авторизованных)
Route::middleware('auth')->group(function () {
    // Аутентификация
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Дашборд
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        $achievementsCount = \App\Models\Dialog::where('student_id', $user->id)->count();
        $activeDialogsCount = \App\Models\Dialog::where(function($q) use ($user) {
            $q->where('student_id', $user->id)
              ->orWhere('teacher_id', $user->id);
        })->whereIn('status', ['waiting', 'active'])->count();
        
        return view('dashboard', compact('achievementsCount', 'activeDialogsCount'));
    })->name('dashboard');
    
    // Аватарка
    Route::post('/avatar/upload', [AvatarController::class, 'upload'])->name('avatar.upload');
    
    // Диалоги
    Route::get('/dialogs', [DialogController::class, 'index'])->name('dialogs.index');
    Route::get('/dialogs/create', [DialogController::class, 'create'])->name('dialogs.create');
    Route::post('/dialogs', [DialogController::class, 'store'])->name('dialogs.store');
    Route::get('/dialogs/{id}', [DialogController::class, 'show'])->name('dialogs.show');
    
    // Сообщения
    Route::post('/dialogs/{id}/messages', [MessageController::class, 'store'])->name('messages.store');
    
    // Цели диалога
    Route::post('/dialogs/{id}/goals', [GoalController::class, 'store'])->name('goals.store');
    Route::post('/goals/{id}/toggle', [GoalController::class, 'toggle'])->name('goals.toggle');
    Route::delete('/goals/{id}', [GoalController::class, 'destroy'])->name('goals.destroy');
    
    // Завершение диалога
    Route::post('/dialogs/{id}/complete', [DialogController::class, 'complete'])->name('dialogs.complete');
    
    // Отмена диалога (для студента)
    Route::delete('/dialogs/{id}/cancel', [DialogController::class, 'cancel'])->name('dialogs.cancel');
    
    // Достижения
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
    
    // Темы для диалогов
    Route::get('/topics', function () {
        return view('topics.index');
    })->name('topics.index');

    // ========== НОВЫЙ МАРШРУТ ДЛЯ ИЗБРАННОГО ==========
    Route::post('/favorites/add', [FavoriteController::class, 'add'])->name('favorites.add');
});