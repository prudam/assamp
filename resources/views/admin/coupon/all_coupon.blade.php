@extends('admin.template.master')

@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Coupon</h2>
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
							<th>User Type</th>
                            <th>Coupon Type</th>
                            <th>Coupon Code</th>
							<th>Coupon Amount</th>
							<th>Status</th>
                            <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody class="form-text-element">
                        @if (count($data) > 0)

                            @foreach ($data as $key => $value)

                                <tr>
									<td>{{ $value->id }}</td>
									<td>
										@php
											if($value->user_type == 1)
												print "Retail Customer";
											else
												print "Seller";
										@endphp
									</td>
                                    <td>
                                        @php
                                            if($value->coupon_type == 1)
                                                print "New User";
                                            else
                                                print "Exist User";
                                        @endphp
									</td>
									<td>{{ $value->coupon_code }}</td>
									<td>{{ $value->coupon_amount }}</td>
									<td>
										@php
											if($value->status == 1)
												print "<a class=\"btn btn-success\">Active</a>";
											else
												print "<a class=\"btn btn-danger\">In-Active</a>";
										@endphp
									</td>
                                    <td>
										@if($value->status == 1)
											<a class="btn btn-danger" href="{{ route('admin.coupon_status_update', ['couponId' => $value->id, 'status' => 2]) }}">In-Active</a>
										@else
											<a class="btn btn-success" href="{{ route('admin.coupon_status_update', ['couponId' => $value->id, 'status' => 1]) }}">Active</a>
										@endif

                                        <a href="{{ route('admin.edit_coupon', ['couponId' => $value->id]) }}" class="btn btn-warning">Edit Info.</a>
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