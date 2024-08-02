<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Models\Account;


class TransactionServices
{
    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }
    public function transfer($request)
    {
        $fromAccount = Account::find($request->from_account);
        $toAccount = Account::where('account_number', $request->to_account)->firstOrFail();

        if ($fromAccount->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient funds.']);
        }
        $data = $this->getExchangeRate($request->fromcurrency,$request->transfercurrency);
        $rate = $data['info']['rate'];
        $amount =$request->amount;
        if($request->fromcurrency != $request->transfercurrency ){
            $exchangerate = $rate - 0.01;
            $request->amount =  $request->amount * $exchangerate;
        }
        $fromAccount->balance -=  $amount;
        $fromAccount->save();
        $toAccount->balance += $request->amount;
        $toAccount->save();
        return $this->repository->transfer($fromAccount,$toAccount,$amount,$request);
    }
    public function getExchangeRate($fromcurrency,$transfercurrency){
        $endpoint = 'convert';
        $access_key = env('EXCHANGE_API_KEY');
        $url= env('EXCHANGE_API_URL');
        //dd($access_key);
        $from = $fromcurrency;
        $to = $transfercurrency;
        $amount = 100;
        $ch = curl_init($url.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');
        //dd($ch);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $json = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            die('CURL Error: ' . $error_msg);
        }
        curl_close($ch);
        $conversionResult = json_decode($json, true);
        if (!$conversionResult || !isset($conversionResult['success']) || !$conversionResult['success']) {
            die('Error: Invalid API response');
        }
        return $conversionResult;
    }
}