<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'players_count',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            $game->game_id = Str::random(15);
        });
    }

    public function players()
    {
        return $this->hasMany(Player::class, 'game_id', 'game_id');
    }
}
