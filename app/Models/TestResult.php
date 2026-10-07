<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'session_id',
        'result_summary',
        'recommendation',
        'is_reviewed',
        'is_sent',
    ];

    protected $casts = [
        'is_reviewed' => 'boolean',
        'is_sent' => 'boolean',
    ];

    public function testSession()
    {
        return $this->belongsTo(TestSession::class, 'session_id');
    }
}
