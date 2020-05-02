@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Product Basic Info. Setup</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            @if(session()->has('msg'))
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            @endif
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.add_product') }}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="top_cate_name">Top-Category</label>
                            <select class="form-control form-text-element" name="top_cate_name" id="top_cate_name" required>
                                <option value="" selected disabled>Choose Top-Category</option>
                                @if(count($data) > 0)
                                    @foreach($data as $key => $value)
                                        <option value="{{ $value->id }}" class="form-text-element">{{ $value->top_cate_name }}</option>
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
                                <option value="" disabled selected>Choose Sub-Category</option>
                            </select>
                            @error('sub_cate_name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="product_name">Product Name</label>
                        <input type="text" class="form-control form-text-element" name="product_name" value="{{ old('product_name') }}" id="product_name" required>
                            @error('product_name')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control form-text-element" name="slug" value="{{ old('slug') }}" id="slug" required>
                            @error('slug')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="color">Color</label>
                            <input type="text" class="form-control form-text-element" name="color" value="{{ old('color') }}">
                            @error('color')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="stock">Stock</label>
                        <input type="number" class="form-control form-text-element" name="stock" value="{{ old('stock') }}" required>
                            @error('stock')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="discount">Discount (In %)</label>
                            <input type="number" min="0" class="form-control form-text-element" name="discount" value="{{ old('discount') }}" required>
                            </select>
                            @error('discount')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="banner">Banner (width: 700*height: 1000)</label>
                            <input type="file" class="form-control form-text-element" name="banner" required>
                            </select>
                            @error('banner')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="slider_images">Slider Images (width: 700*height: 1000)</label>
                            <input type="file" class="form-control form-text-element" name="slider_images[]" required multiple>
                            @error('slider_images')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                        <label for="shipping_amount">Shipping Amount (In per unit)</label>
                        <input type="number" step="0.01" class="form-control form-text-element" name="shipping_amount" value="{{ old('shipping_amount') }}" required>
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

                <div class="well" style="overflow: auto" id="price_div">

                </div>

                {{-- <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="color_id">Color</label>
                            <div id="color_div">

                            </div>
                            @error('color_id')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div> --}}


                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="desc">Description</label>
                            <textarea class="form-control form-text-element ckeditor" name="desc" required>
                                {{ old('desc') }}
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
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Add Product</button>
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

        $.ajax({
            method: "POST",
            url   : "{{ url('/admin/product-price-type') }}",
            data  : {
                'category_id': category_id
            },
            success: function(response) {

                $('#price_div').html(response);
            }
        }); 
    });

    // $('#sub_cate_name').change(function(){
    //     var sub_category_id = $('#sub_cate_name').val();

    //     $('#size_div').html('<b>Loading....</b>');

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //     });

    //     $.ajax({
    //         method: "POST",
    //         url   : "{{ url('/admin/retrive-color') }}",
    //         data  : {
    //             'sub_category_id': sub_category_id
    //         },
    //         success: function(response) {
    //             $('#color_div').html(response);
    //         }
    //     }); 
    // });
});
</script>
@endsection
