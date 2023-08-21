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
        return $request->user();
    }

    public function getById($id)
    {
       return $this->userRepository->getById($id);
    }

    public function addTestResult( $id, Request $request )
    {
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
