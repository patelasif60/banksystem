@extends('layouts.admin') 
@section('content')
<div class="row mt-5 justify-content-left" xmlns="http://www.w3.org/1999/html">
    <form class="create-poll-form repeater" method="post" action="{{route('account.store')}}">
        @csrf
        <div class="col-xl-12">
            <div class="form-group row">
                <div class="col-xl-12">
                    <div class="row m-2 align-items-center">
                        <div class="col-8">
                            <h3 class="block-title">Add Account</h3>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" class="btn btn-primary btn-noborder" data-repeater-create>Add Form</button>
                        </div>
                    </div>
                </div>
                <div class="m-2 col-md-12 js-acc-form" data-repeater-list="addaccount">
                    <div class="form" data-repeater-item>
                        <div class="form-row mb-3">
                            <div class="col">
                                <input required type="text" name="fname" class="form-control" placeholder="First Name">
                            </div>
                            <div class="col">
                                <input required type="text" name="lname" class="form-control" placeholder="Last Name">
                            </div>
                            <div class="col">
                                <input type="email" required name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="col">
                               <select class="form-control" id="currency" name="currency" required>
                                    <option value="">Select Currency</option>
                                    <option value="USD">USD</option>
                                    <option value="GBP">GBP</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="date" name="dob" max='2024-08-02' required class="form-control" placeholder="Date of Birth">
                            </div>
                            <div class="col">
                                <textarea class="form-control" name="address" required placeholder="address"></textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-noborder" data-repeater-delete>Delete</button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="col-12 text-left">
                        <button type="Submit" class="btn btn-primary btn-noborder">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function(){
        initFormRepeaters();
        function  initFormRepeaters () {
            $('.repeater').repeater({
                show: function () {
                    $(this).slideDown();
                    repeaterIncrementText();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                    setTimeout(function() {
                        repeaterIncrementText();
                    }, 1000);
                },
                isFirstItemUndeletable: true,
            });
        };

        function repeaterIncrementText() {
            var repeaterIncrement = 0;
            $(".js-acc-form .form-group").each(function(index) {
                $(this).find('label').text('Option '+ repeaterIncrement+':');
                repeaterIncrement++;
            });
        }
    });

</script>
@endsection