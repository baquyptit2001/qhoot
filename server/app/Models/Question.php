<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'topic_id',
        'user_id',
        'sort_order',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function correctAnswer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    protected static function booted()
    {
        static::deleting(function ($question) {
            $question->answers()->get()->each->delete();
        });
    }


}
