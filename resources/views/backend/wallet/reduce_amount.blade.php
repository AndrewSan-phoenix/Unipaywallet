@extends('backend.layouts.app')
@section('title', 'Reduce Amount')
@section('wallet-active', 'mm-active')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
            <img src="{{asset('img/wallet.png')}}" alt="" style="width:30px;height:30px;">
                <!-- <i class="pe-7s-wallet icon-gradient bg-mean-fruit">
                </i> -->
            </div>
            <div>Reduce Amount</div>
        </div>
    </div>
</div>

<div class="content py-3">
    <div class="card">
        <div class="card-body">
            @include('backend.layouts.flash')

            <form action="{{url("admin/wallet/reduce/amount/store/")}}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="">User</label>
                    <div class="row">
                    <select name="user_id" class="form-select col-md-12 col-sm-12 user_id">
                        <option value="">-- Please Choose --</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}} ({{$user->phone}})</option>
                        @endforeach
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Amount</label>
                    <input type="number" name="amount" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-secondary mr-2 back-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.user_id').select2({
            placeholder: "-- Please Choose --",
            allowClear: true,
            theme: 'bootstrap4',
        });
    } );
</script>
@endsection
