<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'card_name',
        'description',
        'kode',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function cardSessions()
    {
        return $this->hasMany(CardSession::class, 'card_id');
    }
}