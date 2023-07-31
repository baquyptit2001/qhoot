<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'user_id',
        'category_id',
    ];

    public function category()
    {
        Log::channel('debug')->info('category');
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleting(function ($topic) {
            $topic->questions()->get()->each->delete();
        });
    }
}
