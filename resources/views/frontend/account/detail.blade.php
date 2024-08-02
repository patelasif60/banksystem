@extends('layouts.admin') 
@section('content')
    <div class="card mb-4">
        <div class="card-header">
             Account Detail
        </div>
        <div class="card-body">
            <h5 class="card-title">Account Number: {{$account->account_number}}</h5>
            <p class="card-text"><strong>Account Holder:</strong> {{$account->first_name}} {{$account->last_name}}</p>
            <p class="card-text"><strong>Account Balance:</strong> {{$account->balance}}</p>
            <p class="card-text"><strong>Account Status:</strong> {{$account->is_active ? 'Active' : 'Deactive'}}</p>
            @if(auth()->user()->user_type !='Admin')
                <a href="{{ route('transferhistory',["id"=>$account->id]) }}" class="btn btn-primary">View Transactions</a>
                <a href="{{ route('fundtransfer') }}" class="btn btn-primary">Fund Transfer</a>
            @else
                <a href="{{ route('admin.transferhistory',["id"=>$account->id]) }}" class="btn btn-primary">View Transactions</a>
            @endif
        </div>
    </div>
@endsection