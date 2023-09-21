<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Services\Game\Interfaces\GameInterface as GameService;
use App\Repositories\Game\Interfaces\GameInterface as GameRepository;

class GameController extends Controller
{
    public function create( GameRepository $repo, GameService $user, Request $request){
        return $repo->parseResult($user->create($request));
    }

    public function connectGame($id, GameRepository $repo, GameService $user, Request $request){
        return $repo->parseResult($user->connectGame($id, $request));
    }

    public function getById($id, GameRepository $repo, GameService $user){
        return $repo->parseResult($user->getById($id));
    }
}
