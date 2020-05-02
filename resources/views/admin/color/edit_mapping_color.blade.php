@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Color Mapping</h2>
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
            <form method="POST" autocomplete="off" action="{{ route('admin.update_mappping_color', ['color_mapping_id' => encrypt($mapping_color_record[0]->id)]) }}" class="form-horizontal form-label-left">
                @csrf

                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="sub_cate_id">Sub-Category</label>
                            <input type="text" name="sub_cate_id" value="{{ $sub_category_record[0]->sub_cate_name }}" class="form-control col-md-7 col-xs-12" disabled readonly>
                            @error('sub_cate_id')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="color">Color</label>
                            <select  name="color" class="form-control col-md-7 col-xs-12">
                                <option selected disabled value="">Choose Color</option>
                                @if(isset($all_color) && !empty($all_color) && (count($all_color) > 0))
                                    @foreach($all_color as $key => $value)
                                        @if($value->id == $mapping_color_record[0]->color_id)
                                            <option value="{{ $value->id }}" selected>{{ $value->color }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->color }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('color')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Update Mapping</button>
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

@endsection