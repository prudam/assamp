@extends('admin.template.master')

@section('content')

<div class="right_col" role="main">

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>New Seller</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
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
                          <th>Name</th>
                          <th>Email</th>
                          <th>Contact No</th>
                          <th>GST No</th>
                          <th>Opening Date</th>
                          <th>Status</th>
                          <th>View</th>
                        </tr>
                      </thead>


                      <tbody>
                        @if(!empty($new_seller) && (count($new_seller) > 0))
                            @foreach($new_seller as $key => $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->contact_no }}</td>
                                <td>{{ $item->gst_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->toDayDateTimeString() }}</td>
                                <td><a href="{{ route('admin.confirm_seller', ['user_id' => $item->id]) }}" class="btn btn-primary btn-round">Confirm</a></td>
                                <td><a href="{{ route('admin.users_profile', ['user_id' => encrypt($item->id)]) }}" class="btn btn-success btn-round" target="_blank">View Profile</a></td>
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