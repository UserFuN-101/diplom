<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DialogGoal extends Model
{
    protected $table = 'dialog_goals';
    
    protected $fillable = [
        'dialog_id',
        'description',
        'is_completed',
        'is_default',
        'order'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'is_default' => 'boolean'
    ];

    /**
     * Связь с диалогом
     */
    public function dialog()
    {
        return $this->belongsTo(Dialog::class);
    }

    /**
     * Отметить цель как выполненную
     */
    public function markAsCompleted()
    {
        $this->is_completed = true;
        $this->save();
    }

    /**
     * Отметить цель как невыполненную
     */
    public function markAsIncomplete()
    {
        $this->is_completed = false;
        $this->save();
    }

    /**
     * Проверить, выполнена ли цель
     */
    public function isCompleted(): bool
    {
        return $this->is_completed;
    }

    /**
     * Получить цвет статуса для отображения
     */
    public function getStatusColor(): string
    {
        return $this->is_completed ? '#28a745' : '#ffc107';
    }

    /**
     * Получить иконку статуса
     */
    public function getStatusIcon(): string
    {
        return $this->is_completed ? '✓' : '○';
    }
}