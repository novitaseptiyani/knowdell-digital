<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardSession extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'card_id',
        'choice_category_id',
        'profesi_1_score',
        'profesi_2_score',
        'profesi_3_score',
    ];

    public function testSession()
    {
        return $this->belongsTo(TestSession::class, 'session_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function choiceCategory()
    {
        return $this->belongsTo(ChoiceCategory::class, 'choice_category_id');
    }
}