<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendTwoFactorCode;

class AuthController extends Controller
{
    public function register(Request $input){
        $type = User::count()==0 ? 'Admin': 'Customer';
        $user =User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'email_verified_at' =>Carbon::now(),
            'date_of_birth' =>$input['dob'],
            'address' => $input['address'],
            'user_type' => $type,
        ]);
        if($type == 'Customer'){
            Account::create([
                'user_id' => $user->id,
                'account_number' => random_int(1000, 9999).'-'.$user->id.'-'.now()->timestamp,
                'balance' => 1000,
                'currency'=> 'USD',
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'is_active'=> 0,
            ]);
        }
        return redirect()->route('loginview');
    }
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user->two_factor_code = rand(100000, 999999);
            $user->two_factor_expires_at = now()->addMinutes(10);
            $user->save();
            SendTwoFactorCode::dispatch($user, $user->two_factor_code);
            return redirect()->route('verify');
        }
        return redirect()->back()->withErrors(['LoginError' => 'Enter Valid Credential']);
    }
    public function twoStepView(){
        return view('auth.twofactor');
    }
    public function verifyCode(Request $request){
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);
        $user = auth()->user();
        //dd($user);
        if($request->input('two_factor_code') == $user->two_factor_code)
        {
            $user->timestamps = false;
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();
            if($user->user_type=="Admin")
            {
                return redirect()->route('dashboard');
            }
            return redirect()->route('forntdashboard');
        }
        return redirect()->back()->withErrors(['two_factor_code' => 'The two factor code you have entered does not match']);
    
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}