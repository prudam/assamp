@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Coupon</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.add_coupon') }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="user_type">User Type</label>
                            <select name="user_type" class="form-control col-md-7 col-xs-12 form-text-element">
                                <option selected disabled>Choose User</option>
                                <option value ="1">Retail Customer</option>
                                <option value ="2">Seller</option>
                            </select>
                            @error('user_type')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="coupon_type">Coupon For</label>
                            <select name="coupon_type" class="form-control col-md-7 col-xs-12 form-text-element">
                                <option selected disabled>Choose Coupon Type</option>
                                <option value ="1">New User</option>
                                <option value ="2">Exist User</option>
                            </select>
                            @error('coupon_type')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="coupon_amount">Coupon Amount (In Perchantage) </label>
                            <input type="number" name="coupon_amount" value="{{ old('coupon_amount') }}" step="0.01" class="form-control col-md-7 col-xs-12 form-text-element">
                            @error('coupon_amount')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="coupon_code">Coupon Code</label>
                            <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" class="form-control col-md-7 col-xs-12 form-text-element">
                            @error('coupon_code')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="coupon_desc">Coupon Description </label>
                            <input type="text" name="coupon_desc" value="{{ old('coupon_desc') }}" class="form-control col-md-7 col-xs-12 form-text-element">
                            @error('coupon_desc')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Add Coupon</button>
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