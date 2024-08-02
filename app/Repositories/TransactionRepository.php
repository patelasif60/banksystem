<?php
namespace App\Repositories;
use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    public function transfer($fromAccount,$toAccount,$amount,$request)
    {
        Transaction::create([
            'from_account_id' => $fromAccount->id,
            'to_account_id' => $toAccount->id,
            'amount' =>  $amount,
            'exchange_amount'=> $fromAccount->currency != $toAccount->currency ? $request->amount : null,
            'description' => $request->description,
            'transaction_date'=> now(),
            'balance'=>$fromAccount->balance,
        ]);
    }
}