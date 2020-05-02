@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Sliders</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                        <a href="{{ route('admin.slider_form') }}" class="btn btn-primary" style="color: white">Add Slider</a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Slider</th>
                            <th>Text Type</th>
                            <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody class="form-text-element">
                        @if (count($data) > 0)

                            @foreach ($data as $key => $value)

                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td><img src="{{ asset('assets/slider/'.$value->slider.'') }}" height="100px"></td>
                                    <td>
                                      @if ($value->show_text_type == '1')
                                          Coupon Data
                                      @else
                                          Other 
                                      @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.slider_delete', ['id' => $value->id]) }}" class="btn btn-warning btn-round form-text-element">Delete</a>
                                        <a href="{{ route('admin.slider_setting', ['slider_id' => $value->id]) }}" class="btn btn-info btn-round form-text-element">setting</a>
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
        </div>
@endsection