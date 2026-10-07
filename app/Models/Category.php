<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    public function cards()
    {
        return $this->hasMany(Card::class, 'category_id');
    }

    public function choiceCategories()
    {
        return $this->hasMany(ChoiceCategory::class, 'category_id');
    }

    public function testSessions()
    {
        return $this->hasMany(TestSession::class, 'category_id');
    }
}