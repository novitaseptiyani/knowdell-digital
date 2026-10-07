<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselorUser extends Model
{
    use HasFactory;

    protected $table = 'counselor_user';

    public $timestamps = false;

    protected $fillable = [
        'counselor_id', 
        'user_id'    
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function counselor()
    {
        return $this->belongsTo(Staff::class, 'counselor_id');
    }
}