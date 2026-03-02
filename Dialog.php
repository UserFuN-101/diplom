<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    protected $fillable = [
        'topic',
        'student_id',
        'teacher_id',
        'status',
        'final_grade', // ЭТО ПОЛЕ НУЖНО ДОБАВИТЬ!
    ];

    // Связи
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function goals()
    {
        return $this->hasMany(DialogGoal::class)->orderBy('order');
    }
}