<?php


namespace App\Repositories;

use App\Repositories\Interfaces\UserInterface;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->orderBy('id', 'desc')->get();
    }

    public function get(int $userId)
    {
        $user = $this->user->find($userId);
        if (!$user) {
            throw new \Exception('User not found!');
        }

        return $user;
    }

    public function store(Request $request)
    {
        $userArray             = $request->validated();
        $userArray['password'] = Hash::make($userArray['password']);
        $newUser               = $this->user->create($userArray);
        return $newUser;
    }

    public function update(Request $request, int $userId)
    {
        $user                  = $this->get($userId);
        $userArray             = $request->validated();
        $userArray['password'] = Hash::make($userArray['password']);
        $user->update($userArray);
        return $user;
    }

    public function delete(int $userId)
    {
        $user = $this->get($userId);
        $user->delete();
        return true;
    }
}
