@extends('layouts.admin') 
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Transaction History</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $account->account_number }}</li>
        </ol>
        <input type="hidden" value="{{auth()->user()->usertype}}"/>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Transaction History
            </div>
            <div class="card-body">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Description</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@if(auth()->user()->user_type =='Admin')
    @section('page-scripts')
        <script>
            $(document).ready(function() {
                
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.transferhistory', $account->id) }}",
                    columns: [
                        {data: 'transaction_date', name: 'transaction_date'},
                        {data: 'debit', name: 'debit'},
                        {data: 'credit', name: 'credit'},
                        {data: 'description', name: 'description'},
                        {data: 'balance', name: 'balance'},
                    ]
                });
            });
        </script>
    @endsection
@else
    @section('page-scripts')
        <script>
            $(document).ready(function() {
                
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('transferhistory', $account->id) }}",
                    columns: [
                        {data: 'transaction_date', name: 'transaction_date'},
                        {data: 'debit', name: 'debit'},
                        {data: 'credit', name: 'credit'},
                        {data: 'description', name: 'description'},
                        {data: 'balance', name: 'balance'},
                    ]
                });
            });
        </script>
    @endsection
@endif