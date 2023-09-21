<?php

namespace App\Repositories\Game;

use App\Models\Game;
use App\Models\Player;

use Illuminate\Support\Str;
use App\Events\PlayerConnected;

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

    public function create(){
        return $this->model->create();
    }

    public function connectGame($id, $player){
        $game = $this->model->where('game_id', $id)->first();
        if($game){
            if($game->players()->count() == 4){
                return false;
            }
            $newPlayer = $game->players()->create(["name" => $player]);
            event(new PlayerConnected($newPlayer));
            return $game->load('players');
        }
        return false;
    }

    public function getById($id){
        $game = $this->model->where('game_id', $id)->first();
        if($game){
            return $game->load('players');
        }
        return false;
    }

   
}
