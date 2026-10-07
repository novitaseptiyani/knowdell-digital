<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'full_name',
        'phone',
        'birth_date',
        'gender',
        'institution',
        'role',
        'created_by',
        'title', 
        'specialization', 
        'biography',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password'   => 'hashed',
            'birth_date' => 'date',
        ];
    }

    public function createdBy()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    public function createdCounselors()
    {
        return $this->hasMany(Staff::class, 'created_by');
    }

    public function patients()
    {
        return $this->hasManyThrough(
            User::class,
            CounselorUser::class,
            'counselor_id',
            'id',
            'id',
            'user_id'
        );
    }

    public function counselorUsers()
    {
        return $this->hasMany(CounselorUser::class, 'counselor_id');
    }
}
