<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSession extends Model
{
    use HasFactory;

    const CREATED_AT = 'started_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'category_id',
        'status',
        'finished_at',
        'duration',
    ];

    protected $casts = [
        'finished_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function cardSessions()
    {
        return $this->hasMany(CardSession::class, 'session_id');
    }

    public function testResult()
    {
        return $this->hasOne(TestResult::class, 'session_id');
    }
}