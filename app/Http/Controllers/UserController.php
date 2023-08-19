<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\Interfaces\UserInterface as UserService;
use App\Repositories\User\Interfaces\UserInterface as UserRepository;


class UserController extends Controller
{
    public function getById( $id, UserRepository $repo, UserService $user )
    {
        return $repo->parseResult( $user->getById( $id ) );
    }

    public function addTestResult( $id, UserRepository $repo, UserService $user, Request $request )
    {
        return $repo->parseResult( $user->addTestResult( $id, $request ) );
    }

    public function getLeaderboard( UserRepository $repo, UserService $user )
    {
        return $repo->parseResult( $user->getLeaderboard() );
    }
}
