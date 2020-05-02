@extends('admin.template.master')
@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>{{ $product_record[0]->product_name }}</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                      </div>

                      <div class="clearfix"></div>

                      <form action="{{ route('admin.upload_metal_product_slider', ['product_id' => $product_record[0]->id]) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                          @csrf
                          @method('PUT')
                          <div class="well" style="overflow: auto">
                            <div class="form-row mb-3">
                              <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <input type="file" name="slider_images[]" multiple required class="form-control"/><br>
                                <input type="submit" class="btn btn-primary" />
                              </div>
                            </div>
                          </div>
                          </form>

                      @if(!$additional_image_record->isEmpty())

                            @foreach($additional_image_record as $value)

                                <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                                    <div class="well profile_view">
                                      <div class="col-sm-12">
                                        <div class="left col-xs-7">
                                            <a href="{{ route('admin.remove_metal_product_slider_image', ['image_id' => $value->id ]) }}" class="btn btn-danger">Remove</a>
                                            <img src="{{ route('admin.metal_additional_image', ['additional_image_id' => encrypt($value->id) ]) }}" style="width: 290px;" id="img">
                                        </div>
                                      </div>
                                      <div class="col-xs-12 bottom text-center">
                                        <form method="POST" autocomplete="off" action="{{ route('admin.update_metal_product_additional_image', ['additional_image_id' => encrypt($value->id) ]) }}" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="col-xs-12 col-sm-8 emphasis">
                                          <p class="ratings">
                                            <input type="file" name="additional_image" id="additional_image" accept="image/*" required>
                                          </p>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 emphasis">
                                          <button type="submit" class="btn btn-primary btn-xs">
                                            Upload Image
                                          </button>
                                        </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>

                            @endforeach
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection
@section('script')
<script type="text/javascript">
$('#additional_image').change(function(e){

    var url = URL.createObjectURL(e.target.files[0]);
    $('#img').attr('src', url);
});
</script>
@endsection

