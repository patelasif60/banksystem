@extends('layouts.admin') 
@section('content')
    <div class="row mt-5">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Fund Transfer
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('transfer')}}">
                        @csrf
                        <div class="form-group">
                            <label for="from_account">From Account</label>
                            <select id="from_account" name="from_account" class="form-control" required>
                                <option value="" disabled selected>Select Account</option>
                                @foreach($accounts as $account)
                                    @if($account->is_active)
                                        <option value="{{ $account->id }}">{{ $account->account_number }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="to_account">To Account</label>
                            <input type="text" id="to_account" name="to_account" class="form-control" placeholder="Enter Recipient's Account Number" required>
                        </div>
                        <div class="form-group">
                            <label for="to_account">Account Currancy</label>
                            <input readonly type="text" name="fromcurrency" class="form-control" value="{{ $account->currency}}" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="currency">Transfer Currency</label>
                            <select class="form-control" name="transfercurrency" required>
                                <option value="">Select Currency</option>
                                <option value="USD">USD</option>
                                <option value="GBP">GBP</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter Amount" required min="1" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="descriptions">Descriptions</label>
                            <textarea name="description"class="form-control" placeholder="Enter Descriptions"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Transfer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection