<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Repositories\User\Interfaces\UserInterface;
use App\Repositories\Base\BaseRepository;
use App\Models\User;
use App\Notifications\WelcomeNotification;

class UserRepository extends BaseRepository implements UserInterface
{

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
       return $this->model->with(['typingTestResults'])->find($id);
    }

    public function getLeaderboard()
    {
        return $this->model->select('users.name', \DB::raw('MAX(best_results.words_per_minute) as record'))
            ->leftJoinSub(function ($query) {
                $query->from('typing_test_results')
                    ->select('user_id', \DB::raw('MAX(words_per_minute) as words_per_minute'))
                    ->groupBy('user_id');
            }, 'best_results', 'users.id', '=', 'best_results.user_id')
            ->groupBy('users.name')
            ->havingRaw('record > 0') // Adiciona essa cláusula para filtrar words_per_minute maior que 0
            ->orderBy('record', 'desc')
            ->take(10)
            ->get();
    }

    public function getLeaderboardPosition( $id ){
        $user = $this->model->where('user_id', $id)->max('words_per_minute');
        return $user;
    }

    public function addTestResult( $id, $data )
    {
        $user = $this->model->find($id);
        $result = $user->typingTestResults()->create($data);
        return $result;
    }
}
