@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Sub-Category</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Top-Category</th>
                            <th>Sub-Category</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody class="form-text-element">
                        @if (count($data) > 0)

                            @foreach ($data as $key => $value)

                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->top_cate_name }}</td>
                                    <td>{{ $value->sub_cate_name }}</td>
                                    <td>{{ $value->slug }}</td>
                                    <td>
                                        @if($value->status == 1)
                                            <a class="btn btn-success">Active</a>
                                        @else
                                            <a class="btn btn-danger">In-Active</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($value->status == 1)
                                            <a href="{{ route('admin.sub_category_update_status', ['subCategoryId' => $value->id, 'status' => 2]) }}" class="btn btn-danger">In-Active</a>
                                        @else
                                            <a href="{{ route('admin.sub_category_update_status', ['subCategoryId' => $value->id, 'status' => 1]) }}" class="btn btn-success">Active</a>
                                        @endif


                                        <a href="{{ route('admin.edit_sub_category', ['slug' => $value->slug, 'subCategoryId' => $value->id]) }}" class="btn btn-warning form-text-element">Edit Info.</a>
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