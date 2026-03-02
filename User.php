<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'level',
        'xp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function dialogsAsStudent()
    {
        return $this->hasMany(Dialog::class, 'student_id');
    }

    public function dialogsAsTeacher()
    {
        return $this->hasMany(Dialog::class, 'teacher_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}