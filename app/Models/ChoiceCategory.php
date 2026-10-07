<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoiceCategory extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'category_id',
        'name',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function cardSessions()
    {
        return $this->hasMany(CardSession::class, 'choice_category_id');
    }
}