<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Assam Products | Admin Dashboard</title>

    <!-- Bootstrap -->
    <link href="{{ asset('admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">

    <!-- Datatables -->
    <link href="{{ asset('admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('admin/build/css/custom.min.css') }}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{ route('admin.dashboard') }}" class="site_title"><span>Assam Products</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ asset('admin/user/user.png') }}" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Auth::user()->name }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Products <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a>Units Product<span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                <li><a href="{{ route('admin.new_product') }}">New Product</a></li>
                                  <li><a href="{{ route('admin.active_product_list') }}">Active Products</a></li>
                                  <li><a href="{{ route('admin.in_active_product_list') }}">In-Active Products</a></li>
                                  <li><a href="{{ route('admin.product_list') }}">Products List</a></li>
                              </ul>
                        </li>
                        <li><a>Weight Product<span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                <li><a href="{{ route('admin.new_metal_product') }}">New Product</a></li>
                                <li><a href="{{ route('admin.metal_product_list') }}">Products List</a></li>
                              </ul>
                        </li>
                    </ul>
                  </li>
                  <li><a href="{{ route('admin.cart_quantity') }}"><i class="fa fa-edit"></i> Buying Cart Items</a>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.users_list') }}">Users List</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Orders <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.new_orders_list') }}">New Orders</a></li>
                      <li><a href="{{ route('admin.out_for_delivery_orders_list') }}">Accept Order</a></li>
                      {{-- <li><a href="{{ route('admin.delivered_orders_list') }}">Delivered Orders</a></li> --}}
                      {{-- <li><a href="{{ route('admin.canceled_orders_list') }}">Cancel Orders</a></li> --}}
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Coupons <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.new_coupon') }}">New Coupon</a></li>
                      <li><a href="{{ route('admin.all_coupon') }}">All Coupons</a></li>
                    </ul>
                  </li>
{{--                   <li><a><i class="fa fa-edit"></i> Manage Reviews <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.new_reviews_list') }}">New Reviews</a></li>
                      <li><a href="{{ route('admin.verified_reviews_list') }}">Verified Reviews</a></li>
                    </ul>
                  </li> --}}
                  {{-- <li><a><i class="fa fa-edit"></i> Manage Color <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.new_color') }}">New Color</a></li>
                      <li><a href="{{ route('admin.all_color') }}">All Color</a></li>
                      <li><a href="{{ route('admin.new_mappping_color') }}">Color Mapping</a></li>
                    </ul>
                  </li> --}}
                  <li><a><i class="fa fa-edit"></i> Manage Category <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                       <li><a>Sub-Category<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="{{ route('admin.new_sub_category') }}">New Sub-Category</a>
                            </li>
                            <li><a href="{{ route('admin.all_sub_category') }}">All Sub-Category</a>
                            </li>
                          </ul>
                        </li>
                      <li><a href="{{ route('admin.all_top_category') }}">Top-Category</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Home/Privacy Page <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('admin.slider_list') }}">Sliders</a></li>
                      <li><a href="{{ route('admin.header_form') }}">Header/Footer Color & Word/ Privacy Page</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('admin.logout') }}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('admin/user/user.png') }}" alt="">{{ Auth::user()->name }}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{ route('admin.change_password') }}"> Change Password</a></li>
                    <li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">
                        @if(($header_data['new_order_cnt'] > 0) || ($header_data['new_seller_cnt'] > 0))
                            {{ $header_data['new_order_cnt'] + $header_data['new_seller_cnt'] }}
                        @else
                            {{ 0 }}
                        @endif
                    </span>
                  </a>
                  @if(($header_data['new_order_cnt'] > 0) || ($header_data['new_seller_cnt'] > 0))
                      <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        @if($header_data['new_order_cnt'] > 0)
                        <li>
                          <a href="{{ route('admin.new_orders_list') }}">
                            <span><b>({{ $header_data['new_order_cnt'] }}) New Orders</b></span>
                          </a>
                        </li>
                        @endif
                        @if($header_data['new_seller_cnt'] > 0)
                        <li>
                          <a href="{{ route('admin.new_seller_list') }}">
                            <span><b>({{ $header_data['new_seller_cnt'] }}) New Seller</b></span>
                          </a>
                        </li>
                        @endif
                      </ul>
                  @endif
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->