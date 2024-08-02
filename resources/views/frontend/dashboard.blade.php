@extends('layouts.admin') 
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">MNKRe Bank</h1>
            <div class="row">
                @foreach(auth()->user()->accounts as $key => $val )
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Balance {{ $val->account_number}}</div>
                            <div class="card-body">Balance {{ $val->balance}}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                @if($val->is_active)
                                    <a class="small text-white stretched-link" href="{{route('accountdetail',['id'=>$val->id])}}">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                @else
                                    <h6>Please Contact Branch Manager For Activate Your Account</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
@section('page-scripts')
@endsection