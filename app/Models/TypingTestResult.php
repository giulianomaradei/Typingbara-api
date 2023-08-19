<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypingTestResult extends Model
{
    protected $fillable = [
        'user_id',
        'wpm',
        'accuracy',
        'duration_seconds',
    ];

    public static $rules = [
        'user_id' => 'required|integer',
        'wpm' => 'required|numeric',
        'accuracy' => 'required|numeric',
        'duration_seconds' => 'required|integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
