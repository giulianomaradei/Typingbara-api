<?php
namespace App\Services\Game;

use App\Services\Base\BaseService;
use App\Services\Game\Interfaces\GameInterface;
use App\Repositories\Game\Interfaces\GameInterface as GameRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class GameService extends BaseService implements GameInterface
{

    private $gameRepository;

    public function __construct (
        GameRepository $gameRepository
    )
    {
        $this->gameRepository = $gameRepository;
    }

    public function create(Request $request)
    {
        return $this->gameRepository->create();
    }

    public function connectGame($id, Request $request)
    {
        return $this->gameRepository->connectGame($id, $request->player);
    }

    public function getById($id)
    {
        return $this->gameRepository->getById($id);
    }

}
