@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Coupon</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.update_coupon', ['couponId' => encrypt($data->id)]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="user_type">User Type</label>
                            @php
                                if($data->user_type == 1)
                                    $val = "Retail Customer";
                                else
                                    $val = "Seller";
                            @endphp
                            <input type="text" name="user_type" id="user_type"  class="form-control col-md-7 col-xs-12 form-text-element" value="{{ $val }}" required disabled>
                            @error('user_type')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="coupon_type">Coupon Type</label>
                            @php
                                if($data->coupon_type == 1)
                                    $val = "New User";
                                else
                                    $val = "Exist User";
                            @endphp
                            <input type="text"  name="coupon_type" id="coupon_type"  class="form-control col-md-7 col-xs-12 form-text-element" value="{{ $val }}" required disabled>
                            @error('coupon_type')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="coupon_amount">Coupon Amount(In Perchantage) </label>
                            <input type="text" name="coupon_amount" id="coupon_amount"  class="form-control col-md-7 col-xs-12 form-text-element" value="{{ $data->coupon_amount }}" required>
                            @error('coupon_amount')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="coupon_code">Coupon Code</label>
                            <input type="text"  name="coupon_code" id="coupon_code"  class="form-control col-md-7 col-xs-12 form-text-element" value="{{ $data->coupon_code }}" required>
                            @error('coupon_code')
                                {{ $message }}
                            @enderror
                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="coupon_desc">Coupon Description </label>
                            <input type="text" name="coupon_desc" value="{{ $data->coupon_desc }}" class="form-control col-md-7 col-xs-12 form-text-element">
                            @error('coupon_desc')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Save Coupon</button>
                    <a href="{{ route('admin.all_coupon') }}" class="btn btn-warning">Back</a>
                  </div>
                </div>
            </form>
            <!-- End New User registration -->
            </div>
          </div>
        </div>
      </div>
</div>
@endsection