<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'full_name',
        'phone',
        'gender',
        'status',
        'institution',
        'birth_date',
        'work_history',
        'dream_jobs',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'birth_date' => 'date',
            'work_history' => 'array',
            'dream_jobs'   => 'array',
        ];
    }

    public function testSessions()
    {
        return $this->hasMany(TestSession::class, 'user_id');
    }

    public function counselor()
    {
        return $this->hasOne(CounselorUser::class, 'user_id');
    }
}