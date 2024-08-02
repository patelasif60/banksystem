<?php
namespace App\Services;

use App\Repositories\AuthRepository;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendTwoFactorCode;

class AuthServices
{
    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }
    public function register($input){
        return $this->repository->register($input);
    }
    public function login($request,$user){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user->two_factor_code = rand(100000, 999999);
            $user->two_factor_expires_at = now()->addMinutes(10);
            $user->save();
            SendTwoFactorCode::dispatch($user, $user->two_factor_code);
            return redirect()->route('verify');
        }
    }
}