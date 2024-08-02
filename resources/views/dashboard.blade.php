@extends('layouts.admin') 
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
            </ol>
            <div class="row">
                <div class="col-md-12 mb-1">
                    <a href="{{route('account.create')}}" class="btn btn-primary btn-sm float-right">Add Account</a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Account List
                </div>
                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Account Number</th>
                                <th>Name</th>
                                <th>Balance</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('page-scripts')
    <script>
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index')}}",
                columns: [
                    {data:'account_number', name:'account_number'},
                    {data: 'full_name', name: 'first_name'},
                    {data: 'balance', name: 'balance'},
                    {data: 'email', name: 'email'},
                    {data: 'action', name: 'action', orderable: false, searchable: true},
                ]
            });
            $(document).on('click', '.toggle-status', function() {
                var accountId = $(this).data('id');
                $.ajax({
                    url: "{{ route('accounts.statuschange') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: accountId
                    },
                    success: function(response) {
                        table.ajax.reload();
                    }
                });
            });
        });
    </script>
@endsection