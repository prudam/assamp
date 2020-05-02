@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Product Color</h2>
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
            <form method="POST" autocomplete="off" action="{{ route('admin.update_product_color', ['product_id' => encrypt($product_record[0]->id)]) }}" class="form-horizontal form-label-left">
                @csrf

                <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label >Product</label>
                            <input type="text" value="{{ $product_record[0]->product_name }}" class="form-control col-md-7 col-xs-12" disabled>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                            <label for="color">Color</label>
                            <select name="color" class="form-control col-md-7 col-xs-12">
                                <option selected disabled value="">Choose Color</option>
                                @if(isset($all_color) && !empty($all_color) && (count($all_color) > 0))
                                    @foreach($all_color as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->color }}</option>
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
                    <button type="submit" name="submit" class="btn btn-success form-text-element">Add Mapping</button>
                    <button class="btn btn-warning" onclick="javascript:window.close()">Close</button>
                  </div>
                </div>
            </form>
            <!-- End New User registration -->
            </div>
          </div>
        </div>
      </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Product Color</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Color</th>
                            <th>Status</th>
                        </tr>
                      </thead>
                      <tbody class="form-text-element">
                        @if (count($product_colors) > 0)

                            @foreach ($product_colors as $key => $item)

                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->color }}</td>
                                    <td>
                                        @if($item->status == 1)
                                            <a href="{{ route('admin.change_product_color_status', ['product_mapping_id' => encrypt($item->id), 'status' => encrypt(0)]) }}" class="btn btn-warning form-text-element">In-Active</a>
                                        @else
                                            <a href="{{ route('admin.change_product_color_status', ['product_mapping_id' => encrypt($item->id), 'status' => encrypt(1)]) }}" class="btn btn-warning form-text-element">Active</a>
                                        @endif
                                    </td>
                                </tr> 
                            @endforeach
                        @endif
                      </tbody>
                    </table>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection

@section('script')

@endsection