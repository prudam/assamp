@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Product Basic Info.</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.update_product', ['product_id' => encrypt($product_record[0]->id) ]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <select class="form-control form-text-element" name="top_cate_name" id="top_cate_name" required>
                                <option value="" selected disabled>Choose Top-Category</option>
                                @if(count($all_top_category) > 0)
                                    @foreach($all_top_category as $key => $value)
                                        @if($product_record[0]->top_cate_id == $value->id)
                                            <option value="{{ $value->id }}" class="form-text-element" selected>{{ $value->top_cate_name }}</option>
                                        @else
                                            <option value="{{ $value->id }}" class="form-text-element">{{ $value->top_cate_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('top_cate_name')
                                {{ $message }}
                            @enderror
                        </div>

                         <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_name">Sub-Category</label>
                            <select name="sub_cate_name" id="sub_cate_name"  class="form-control col-md-7 col-xs-12 form-text-element" required>
                                <option value="" selected>Choose Sub-Category</option>
                                @if(count($all_sub_category) > 0)
                                    @foreach($all_sub_category as $key => $value)
                                        @if($product_record[0]->sub_category_id == $value->id)
                                            <option value="{{ $value->id }}" class="form-text-element" selected>{{ $value->sub_cate_name }}</option>
                                        @else
                                            <option value="{{ $value->id }}" class="form-text-element">{{ $value->sub_cate_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('sub_cate_name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="product_name">Product Name</label>
                        <input type="text" class="form-control form-text-element" name="product_name" id="product_name" value="{{ $product_record[0]->product_name }}" required>
                            </select>
                            @error('product_name')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="slug">Slug</label>
                        <input type="text" class="form-control form-text-element" name="slug" value="{{ $product_record[0]->slug }}" id="slug" required>
                            </select>
                            @error('slug')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="color">Color</label>
                            <input type="text" class="form-control form-text-element" name="color" value="{{ $product_record[0]->color }}">
                            @error('color')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="stock">Stock</label>
                        <input type="text" class="form-control form-text-element" name="stock" value="{{ $product_record[0]->stock }}" id="stock" required>
                            </select>
                            @error('stock')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="discount">Discount (In %)</label>
                            <input type="number" min="0" class="form-control form-text-element" name="discount" value="{{ $product_record[0]->discount }}" required>
                            </select>
                            @error('discount')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                        <label for="shipping_amount">Shipping Amount (In per unit)</label>
                        <input type="number" step="0.01" class="form-control form-text-element" name="shipping_amount" value="{{ $product_record[0]->shipping_amount }}" required>
                            @error('shipping_amount')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="per_units">Per Units</label>
                            <input type="number" class="form-control form-text-element" name="per_units" value="1" disabled>
                            @error('per_units')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="desc">Description</label>
                            <textarea class="form-control form-text-element ckeditor" name="desc" required>
                                {{ $product_record[0]->desc }}
                            </textarea>
                            @error('desc')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Save Product</button>
                    <a onclick="window.close()" class="btn btn-warning form-text-element">Close</a>
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

@section('script')
<script type="text/javascript">

$(document).ready(function(){

    $("#product_name").keyup(function(){
        $("#slug").val($("#product_name").val().toLowerCase());
    });
});
</script>

<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">
$('.ckeditor').ckeditor();
$(document).ready(function(){
    $('#top_cate_name').change(function(){
        var category_id = $('#top_cate_name').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
            method: "POST",
            url   : "{{ url('/admin/retrive-sub-category') }}",
            data  : {
                'category_id': category_id
            },
            success: function(response) {

                $('#sub_cate_name').html(response);
            }
        }); 
    });
});
</script>
@endsection