<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'question_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    protected static function booted()
    {
        static::deleting(function ($answer) {
            $answer->question()->update(['correct_answer_id' => null]);
        });
    }
}
