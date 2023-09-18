<?php

namespace App\Repositories\Game;

use App\Models\Game;
use App\Models\Player;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Base\BaseRepository;
use App\Notifications\WelcomeNotification;
use App\Repositories\Game\Interfaces\GameInterface;

class GameRepository extends BaseRepository implements GameInterface
{

    public function __construct(Game $model, Player $player)
    {
        $this->model = $model;
    }

    public function create($player){
        $game = $this->model->create();
        $game->players()->create(["name" => $player]);
        return $game;
    }

    public function connectGame($id, $player){
        $game = $this->model->where('game_id', $id)->first();
        if($game){
            if($game->players()->count() == 4){
                return false;
            }
            $game->players()->create(["name" => $player]);
            return $game->load('players');
        }
        return false;
    }

   
}
