<?php
namespace App\Services\User;

use App\Services\Base\BaseService;
use App\Services\User\Interfaces\UserInterface;
use App\Repositories\User\Interfaces\UserInterface as UserRepository;
use App\Models\TypingTestResult;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserService extends BaseService implements UserInterface
{

    private $userRepository;

    public function __construct (
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function getUser(Request $request)
    {
        $user = $request->user()->load(['typingTestResults']);

        $typingTestResults = $user->typingTestResults;

        $maxWpm = $typingTestResults->max('words_per_minute');
        $averageWpm = floor($typingTestResults->avg('words_per_minute'));
        $averageAccuracy = floor($typingTestResults->avg('accuracy'));
        $numberOfTests = $typingTestResults->count();

        $leaderboardPosition = $this->userRepository->getLeaderboardPosition($user->id);

        $analytics = [
            'max_wpm'          => $maxWpm,
            'average_wpm'      => $averageWpm,
            'average_accuracy' => $averageAccuracy,
            'number_of_tests'  => $numberOfTests,
            'position'         => $leaderboardPosition
        ];

        $user->analytics = $analytics;

        return $user;
    }

    public function getById($id)
    {
       return $this->userRepository->getById($id);
    }

    public function addTestResult( $id, Request $request )
    {
        dd(openssl_decrypt($request->data, 'aes-256-ecb', ENV('ENCRYPTION_KEY')));
        $data = $request->validate(TypingTestResult::$rules);
        return $this->userRepository->addTestResult( $id, $data );
    }

    public function getLeaderboard()
    {
        return $this->userRepository->getLeaderboard();
    }

    public function delete($id)
    {
        $user = $this->userRepository->find($id);
        return $user->delete();
    }

    public function save( Request $request, $id )
    {
        $this->userRepository->validate(
            $request->all(),
            $this->userRepository->getRules()
        );

        $update = $request->except([
            'old_password',
            'password',
            'password_confirmation'
        ]);

        if( Auth::User()->id !== $request->get('id') &&
            !empty($request->password) &&
            (
                Auth::User()->hasModule('users')
            )
        ) {
            $update['password'] = Hash::make($request->password);
        }

        if(!empty($request->old_password)){
            $current_password = Auth::User()->password;

            if(Hash::check($request->old_password, $current_password)) {
                $update['password'] = Hash::make($request->password);
            } else {
                throw new \Exception("Senha não confere", 400);

            }
        }

        $user = $this->userRepository->update($update, $id);
        return $user;
    }
}
