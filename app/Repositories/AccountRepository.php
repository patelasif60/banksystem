<?php
namespace App\Repositories;
use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;
use App\Jobs\SendOpenAccountMail;
use App\Models\Transaction;

class AccountRepository extends BaseRepository
{

    public function loadData(){
        return  Account::with('user')->select('accounts.*');
    }
    public function store($val){
        $user = User::where('email',$val['email'])->first();
        if(!$user)
        {
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            $pass= substr(str_shuffle($data), 0, 7);
            $user = $this->userStore($val,$pass);
            SendOpenAccountMail::dispatch($user,$pass);
            $this->accountStore($user,$val);
        }
    }
    public function userStore($val,$pass){
        return User::create([
            'first_name' => $val['fname'],
            'last_name' => $val['lname'],
            'email' => $val['email'],
            'password'=>$pass,
            'email_verified_at' =>Carbon::now(),
            'date_of_birth' =>$val['dob'],
            'address' => $val['address'],
            'user_type' => 'Customer',
        ]);
    }
    public function accountStore($user,$val){
        $account = Account::create([
            'user_id' => $user->id,
            'account_number' => random_int(1000, 9999).'-'.$user->id.'-'.now()->timestamp,
            'balance' => 10000,
            'currency'=> $val['currency'],
            'first_name' => $val['fname'],
            'last_name' => $val['lname'],
            'is_active'=> 1,
        ]);
        Transaction::create([
            'from_account_id' => null,
            'to_account_id' => $account->id,
            'amount' =>  10000,
            'exchange_amount'=> null,
            'description' => 'Opening Balance',
            'transaction_date'=> now(),
            'balance'=>null,
        ]);
    }
    public function changestatus($request){
        return Account::find($request->id);
    }
}