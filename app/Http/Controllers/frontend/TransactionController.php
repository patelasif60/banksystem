<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use DataTables;
use App\Services\TransactionServices;

class TransactionController extends Controller
{
    public function __construct(TransactionServices $service)
    {
        $this->service = $service;
    }
    public function fundTransferView(){
        $accounts = auth()->user()->accounts;
        return view('frontend.account.fundtransfer',compact('accounts'));
    }
    public function transfer(Request $request)
    {
        $this->service->transfer($request);
        return redirect()->route('forntdashboard')->with('success', 'Funds transferred successfully.');
    }
    public function transferhistory(Request $request, $id){
        if ($request->ajax()) {
            $account = Account::find($id);
            $balance= 10000;
            $transactions = Transaction::where('from_account_id', $id)->orWhere('to_account_id', $id)->orderBy('transaction_date', 'asc')->get();
            $runningBalance = $balance;
            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('debit', function($row) use ($id) {
                    return $row->from_account_id == $id ? number_format($row->amount, 2) : '-';
                })
                ->addColumn('credit', function($row) use ($id) {
                    if($row->exchange_amount){
                        return $row->to_account_id == $id ? number_format($row->exchange_amount, 2) : '-';
                    }
                    return $row->to_account_id == $id ? number_format($row->amount, 2) : '-';
                })
                ->addColumn('balance', function($row)  use ($id,&$runningBalance) {
                    if($row->from_account_id == $id){
                        $runningBalance -=$row->amount;
                    }if($row->to_account_id == $id && $row->from_account_id)
                    {
                        if($row->exchange_amount){
                            return $runningBalance += $row->exchange_amount; 
                        }else{
                            $runningBalance +=$row->amount;
                        }
                    }
                    return number_format($runningBalance, 2);
                })
                ->addColumn('description', function($row) {
                    return $row->description;
                })
                ->rawColumns(['debit', 'credit', 'balance','amount','description'])
                ->make(true);
        }
        $account = Account::find($id);
        if($account){
            if($account->user_id != auth()->user()->id){
                if(auth()->user()->user_type !='Admin'){
                    abort(403, 'Unauthorized');
                }
            }
            return view('frontend.account.history', compact('account'));
        }
        return redirect()->route('dashboard');
    }
}