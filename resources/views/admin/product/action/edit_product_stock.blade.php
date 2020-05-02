@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Update Product Price</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.update_product_stock', ['product_id' => encrypt($product_id)]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @csrf
                <div class="well" style="overflow: auto">
                    @if (count($product_price) > 0)
                        @foreach ($product_price as $item)
                            <div class="form-row mb-3">
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="type">Type</label>
                                    @if($item->type == 2)
                                        <input type="text" class="form-control form-text-element"  required value="Raw" disabled>
                                        <input type="hidden" name="type[]" class="form-control form-text-element" value="2" required>
                                    @else
                                        <input type="text" class="form-control form-text-element"  required value="Ready to wear" disabled>
                                        <input type="hidden" name="type[]" class="form-control form-text-element" value="1" required>
                                    @endif
                                    @error('type')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="customer_price">Customer Price</label>
                                    <input type="text" class="form-control form-text-element" name="customer_price[]" value="{{ $item->customer_price }}" required>
                                    @error('customer_price')
                                        {{ $message }}
                                    @enderror
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="whole_seller_price">Whole Seller Price</label>
                                    <input type="text" class="form-control form-text-element" name="whole_seller_price[]" value="{{ $item->distributor_price }}" required>
                                    @error('whole_seller_price')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        @endforeach  
                    @else
                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="type">Type</label>
                                <input type="text" class="form-control form-text-element"  required value="Raw" disabled>
                                <input type="hidden" name="type[]" class="form-control form-text-element" value="2" required>
                                @error('type')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="customer_price">Customer Price</label>
                                <input type="text" class="form-control form-text-element" name="customer_price[]" value="0" required>
                                @error('customer_price')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="whole_seller_price">Whole Seller Price</label>
                                <input type="text" class="form-control form-text-element" name="whole_seller_price[]" value="0" required>
                                @error('whole_seller_price')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="type">Type</label>
                                <input type="text" class="form-control form-text-element"  required value="Ready Made" disabled>
                                <input type="hidden" name="type[]" class="form-control form-text-element" value="1" required>
                                @error('type')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="customer_price">Customer Price</label>
                                <input type="text" class="form-control form-text-element" name="customer_price[]" value="0" required>
                                @error('customer_price')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="whole_seller_price">Whole Seller Price</label>
                                <input type="text" class="form-control form-text-element" name="whole_seller_price[]" value="0" required>
                                @error('whole_seller_price')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>      
                    @endif
                </div>
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Update Price</button>
                    <button class="btn btn-warning" onclick="javascript:window.close()">Close</button>
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
