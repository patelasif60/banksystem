<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendTwoFactorCode;

class AuthRepository extends BaseRepository
{
    public function register($input)
    {
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
    }
}