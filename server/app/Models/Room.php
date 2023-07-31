<?php

namespace App\Models;

use App\Http\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        "user_id",
        "name",
        "description",
        "password",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->hasOne(Topic::class);
    }

    public function competitors()
    {
        return $this->hasMany(RoomUser::class);
    }
}
