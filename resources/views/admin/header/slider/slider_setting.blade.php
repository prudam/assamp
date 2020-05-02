@extends('admin.template.master')

@section('content')
@if (isset($slider) && !empty($slider))

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-2 col-sm-2 col-xs-12"></div>
      <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Slider Setting</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <center>
                @if(session()->has('msg'))
                    <b>{{ session()->get('msg') }}</b>
                @endif
                <br>
            </center>
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" action="{{ route('admin.slider_setting_update') }}" class="form-horizontal form-label-left">
              <input type="hidden" value="{{$slider->id}}" name="slider_id">
                @csrf
                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="type">Select Show Slider Text Type</label>
                            <select id="slider_text_type" name="type" class="form-control col-md-7 col-xs-12">
                              <option value="1" {{ $slider->show_text_type == 1 ? 'selected' : '' }}>Coupon</option>
                              <option value="2" {{ $slider->show_text_type == 2 ? 'selected' : '' }}>Other Text</option>
                            </select>
                            @error('type')
                                {{ $message }}
                            @enderror
                        </div>
                        <div id="text_area_div">
                          @if ($slider->show_text_type == '2')
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="title">Title</label>
                                <input type="text" name="title" value="{{$slider->other_title}}" class="form-control col-md-7 col-xs-12" required>  
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                              <label for="bold_text">Bold Text</label>
                              <input type="text" name="bold_text" value="{{$slider->bold_text}}" class="form-control col-md-7 col-xs-12" required>    
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                              <label for="description">Description</label>
                              <textarea name="description" value="{{$slider->description}}" class="form-control col-md-7 col-xs-12" required></textarea>
                            </div>
                          @endif
                         
                        </div>

                      </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <button type="submit" name="submit" class="btn btn-success form-text-element">Update</button>
                </div>
            </form>
            <!-- End New User registration -->
            </div>
          </div>
        </div>
      </div>
</div>   

@endif
@endsection
@if (isset($slider) && !empty($slider) && ($slider->show_text_type == '2'))
@section('script')
    <script>
      $("#slider_text_type").change(function(){
        var value = $(this).val();
        if (value == '2') {
          var html = '<div class="col-md-12 col-sm-12 col-xs-12 mb-3">'+
              '<label for="title">Title</label>'+
              '<input type="text" value="aaaaaa" name="title" class="form-control col-md-7 col-xs-12" required>  '+
          '</div>'+
          '<div class="col-md-12 col-sm-12 col-xs-12 mb-3">'+
            '<label for="bold_text">Bold Text</label>'+
            '<input type="text" name="bold_text" class="form-control col-md-7 col-xs-12" required>'+ 
          '</div>'+
          '<div class="col-md-12 col-sm-12 col-xs-12 mb-3">'+
            '<label for="description">Description</label>'+
            '<textarea name="description" class="form-control col-md-7 col-xs-12" required></textarea>'+
          '</div>';
          $("#text_area_div").html(html);
        } else {
          $("#text_area_div").html('');
        }
      });
    </script>
@endsection
@else
@section('script')
    <script>
      $("#slider_text_type").change(function(){
        var value = $(this).val();
        if (value == '2') {
          var html = '<div class="col-md-12 col-sm-12 col-xs-12 mb-3">'+
              '<label for="title">Title</label>'+
              '<input type="text" name="title" class="form-control col-md-7 col-xs-12" required>  '+
          '</div>'+
          '<div class="col-md-12 col-sm-12 col-xs-12 mb-3">'+
            '<label for="bold_text">Bold Text</label>'+
            '<input type="text" name="bold_text" class="form-control col-md-7 col-xs-12" required>'+ 
          '</div>'+
          '<div class="col-md-12 col-sm-12 col-xs-12 mb-3">'+
            '<label for="description">Description</label>'+
            '<textarea name="description" class="form-control col-md-7 col-xs-12" required></textarea>'+
          '</div>';
          $("#text_area_div").html(html);
        } else {
          $("#text_area_div").html('');
        }
      });
    </script>
@endsection
@endif
