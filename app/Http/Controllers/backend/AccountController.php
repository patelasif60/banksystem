<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Services\AccountServices;

class AccountController extends Controller
{
    public function __construct(AccountServices $service)
    {
        $this->service = $service;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->service->loadData();
        }
    }
    public function create()
    {
        $user = User::all();
        return view('backend.account.create',compact('user'));
    }
    public function store(Request $input){
        $this->service->store($input);
        return redirect()->route('dashboard');
    }
    public function changestatus(Request $request){
        return $this->service->changestatus($request);
    }
    public function accountDetail($id){
        $account = Account::find($id);
        if($account){
            if($account->user_id != auth()->user()->id){
                if(auth()->user()->user_type !='Admin'){
                    abort(403, 'Unauthorized');
                }
            }
            return view('frontend.account.detail',compact('account'));
        }
        return redirect()->route('dashboard');
    }
}