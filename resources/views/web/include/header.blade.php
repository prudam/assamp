<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic page needs -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Assam Product - Best of Online Shopping</title>

  <!-- Mobile specific metas  -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('web.include.seo')

  <!-- Favicon  -->
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- CSS Style -->
  <link rel="stylesheet" href="{{asset('web/css/link-style.css')}}">
  <link rel="stylesheet" href="{{asset('web/css/custom.css')}}">
  
    {{-- CSS Style For Customization --}}
  <style>
      /*---- Header Middle ----*/
    .header-container, nav, .footer-top,  #search, .mini-cart .basket a {background: @php print $header_data['header_color']->header_middle_color @endphp;}

    /*---- Header & Footer All Writeup ----*/
    .jtv-top-links .links li a, .welcome-msg, #nav li a, footer address p, footer .footer-top a, .jtv-logo-box .logo a h1 {color: @php print $header_data['header_color']->header_word_color @endphp;}
    #search, .jtv-top-cart-box .price, .mini-cart .basket a span.cart_count {color: @php print $header_data['header_color']->header_top_color @endphp;}
    .search-box, .mini-cart .basket a {border-color: @php print $header_data['header_color']->header_top_color @endphp;}

    /*---- Header top, boottom, footer-top ----*/
    .header-top, #nav, .jtv-sticky-header {background-color:  @php print $header_data['header_color']->header_top_color @endphp;}

    /*----- Footer Section ------*/
    footer {background-color:  @php print $header_data['header_color']->footer_background_color @endphp;}
    .footer-bottom {border-top: 1px solid @php print $header_data['header_color']->footer_word_color @endphp;}
    footer a, footer p, footer .coppyright, footer h4 {color: @php print $header_data['header_color']->footer_word_color @endphp!important;}

    /*---- Mobile Sidebar Logo ----*/
    .jtv-search-mob .logo {background: @php print $header_data['header_color']->header_top_color @endphp;padding: 0;margin: 0;border-radius: 10px;width: 100%;} 
    .jtv-search-mob .logo h3 {padding: 0;margin: 0;color: @php print $header_data['header_color']->header_word_color @endphp;font-weight: 700;}
    /*---- //Mobile Sidebar Logo ----*/
  </style>
</head>

<body class="cms-index-index cms-home-page">

  <!-- mobile menu -->
  <div id="jtv-mobile-menu">
    <ul>
      <li>
        <div class="jtv-search-mob">
          <div class="logo" style="background:#fff;"> <a title="Assam Product" href="{{route('web.index')}}">
            <img style="max-height:100px;" alt="Assam Product Logo" src="{{asset('web/images/logo1.jpg')}}"></a></div>

        </div>
      </li>
      <li><a href="{{route('web.index')}}">Home</a></li>
      <li><a href="{{route('web.extra.about')}}">About Eagle Group</a></li>
      @if(!empty($header_data['categories']) && (count($header_data['categories']) > 0))
          @foreach($header_data['categories'] as $key => $item)
          <li><a>{{ $item['top_cate_name'] }}</a>
            <ul>
                @if($item['top_category_id'] == 4)
                    @if(!empty($item['sub_categories']) && (count($item['sub_categories']) > 0))
                        @foreach($item['sub_categories'] as $key_1 => $item_1)
                            <li>
                                <a href="{{route('web.bell_brass_metal_product_list', ['slug' => $item_1->slug, 'sub_category_id' => $item_1->id])}}">
                                    <span>
                                        {{ $item_1->sub_cate_name }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    @endif
                @else
                    @if(!empty($item['sub_categories']) && (count($item['sub_categories']) > 0))
                        @foreach($item['sub_categories'] as $key_1 => $item_1)
                            <li>
                                <a href="{{route('web.product_list', ['slug' => $item_1->slug, 'sub_category_id' => $item_1->id, 'sorted_by' => 1])}}">
                                    <span>
                                        {{ $item_1->sub_cate_name }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    @endif
                @endif
            </ul>
          </li>
          @endforeach
      @endif
    </ul>
    <div class="jtv-top-link-mob">
      <ul class="links">
      @auth('users')
        <li style="padding-top: 18px;background: #eee"><a><strong>Welcome, {{Auth::guard('users')->user()->name}}</strong></a> </li>
        <li><a title="cart" href="{{route('web.view_cart')}}">cart</a> </li>
        <li><a title="Wishlist" href="{{ route('web.wish_list') }}">Wishlist</a> </li>
        <li><a title="Signup" href="{{ route('web.logout') }}">Logout</a> </li>
      @else
        <li><a title="cart" href="{{route('web.view_cart')}}">cart</a> </li>
        <li><a title="Signin" href="{{route('web.login')}}">Signin</a> </li>
        <li><a title="Signin" href="{{route('user.registration_page')}}">Signup</a> </li>
      @endauth  
        <li><a href="{{route('web.extra.about')}}"> About Us</a> </li>
        <li><a href="{{route('web.extra.privacy')}}"> Terms & Condition </a> </li>
      </ul>
    </div>
  </div>
  <div id="page"> 
    
    <!-- Header -->
    <header>
      <div class="header-container">
        <div class="header-top">
          <div class="container">
            <div class="row"> 
              <!-- Header Language -->
              <div class="col-sm-12">
                <div class="welcome-msg">{{ $header_data['header_color']->header_top_title }}  </div>
                <!-- End Header Language -->                 
              </div>
            </div>
          </div>
        </div>
        <div class="header-top">
          <div class="container">
            <div class="row"> 
              <div class="col-xs-12 hidden-xs"> 
                <!-- Header Top Links -->
                <div class="jtv-top-links">
                  <div class="links">
                    <ul>
                      <li><a href="{{route('web.extra.about')}}"> About Us </a> </li>
                      <li class="social-network phon">
                        <a><i class="fa fa-phone"></i></a>
                        <div class="hellohi">
                          <span class="triup glyphicon glyphicon-triangle-top" style="left: 38%"></span>
                          <h5 style="text-align: center;">
                            {{ $header_data['header_color']->header_call_no }}<br>
                            Call / Whatsapp<br>(9AM - 9PM)
                          </h5>
                        </div>
                      </li>
                      <li class="social-network"><a title="{{ $header_data['header_color']->header_email }}"><i class="fa fa-envelope"></i></a></li>
                      <li class="social-network"><a title="Connect us on Facebook" target="_blank" href="https://www.facebook.com/Eagle-Group-1150406678338693/"><i class="fa fa-facebook"></i></a></li>
                      <li class="social-network"><a title="Connect us on Instagram" target="_blank" href="https://www.instagram.com/eaglegroup.assam/"><i class="fa fa-instagram"></i></a>
                      </li><li class="social-network"><a title="Connect us on Pinterest" target="_blank" href="https://in.pinterest.com/eaglegroupassam/"><i class="fa fa-pinterest-p"></i></a></li>
                    </ul>
                  </div>
                </div>
                <!-- End Header Top Links --> 
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-1 col-md-4 col-sm-1 col-xs-12 jtv-logo-box hidden-xs logo-box12">
              <div class="logo" style="margin: 10px 0 0;"> 
                <a title="Assam Product" href="{{route('web.index')}}"><img width="100%" alt="Assam Product Logo" src="{{asset('web/images/logo1.jpg')}}"></a> 
              </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 srch">
              <div class="mm-toggle-wrap" style="z-index: 9999999">
                <button class="mm-toggle1" id="this-togg"><i class="fa fa-search" style="margin-top: -5px;padding: 7px 9px;"></i></button>
              </div>
              <div class="search-box">
              <form action="#" method="get" id="search_form">
                @csrf
                  <input type="text" placeholder="Search entire store here..." maxlength="70" name="search" id="search" autocomplete="off">   
              </form>
              </div>
              <div class="col-md-12" id="livesearch"> 
                <!-- if no product fount on search  --> 
                
              </div>
            </div>
            <div class="col-lg-5 col-md-4 col-sm-5 col-xs-10 jtv-logo-box"> 
              <!-- Header Logo -->
              <div class="logo"> 
                <a title="Assam Product" href="{{route('web.index')}}"><h1>{{ $header_data['header_color']->header_title }}</h1> </a> 
              </div>
              <div class="hidden-lg hidden-sm hidden-md" style="margin-top: 60px;">
                <div class="jtv-top-links">
                  <div class="links">
                    <ul>
                      <li class="social-network phon">
                        <a title="Connect us on phone or whatsapp"><i class="fa fa-phone"></i></a>
                        <div class="hellohi">
                          <span class="triup glyphicon glyphicon-triangle-top" style="left: 38%"></span>
                          <h5 style="text-align: center;">
                            {{ $header_data['header_color']->header_call_no }}<br>
                            Call / Whatsapp<br>(9AM - 9PM)
                          </h5>
                        </div>
                      </li>
                      <li class="social-network"><a title="{{ $header_data['header_color']->header_email }}" href="mailto:{{ $header_data['header_color']->header_email }}"><i class="fa fa-envelope"></i></a></li>
                      <li class="social-network"><a title="Connect us on Facebook" target="_blank" href="https://www.facebook.com/Eagle-Group-1150406678338693/"><i class="fa fa-facebook"></i></a></li>
                      <li class="social-network"><a title="Connect us on Instagram" target="_blank" href="https://www.instagram.com/eaglegroup.assam/"><i class="fa fa-instagram"></i></a>
                      </li><li class="social-network"><a title="Connect us on Pinterest" target="_blank" href="https://in.pinterest.com/eaglegroupassam/"><i class="fa fa-pinterest-p"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- End Header Logo --> 
            </div>
            <div class="col-lg-3 col-md-4 col-sm-2 col-xs-2 hwqd">
              <div class="jtv-top-cart-box" style="float: right;">
                <div class="mini-cart">
                  <div class="basket heart">
                    <a href="{{route('web.wish_list')}}" title="WISHLIST"> 
                    </a>
                  </div>
                </div>
              </div>
              <div class="jtv-top-cart-box" style="float: right;"> 
                <!-- Top Cart -->
                <div class="mini-cart">
                  <div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle">
                    <a href="{{ route('web.view_cart') }}"> 
                      <span class="cart_count hidden-sm">
                          @if(!empty($header_data['cart_data']) && count($header_data['cart_data']) > 0)
                              {{ count($header_data['cart_data']) }}
                          @else
                              {{ 0 }}
                          @endif
                      </span>
                      <span class="price hidden-sm">items on Bag</span>
                    </a>
                  </div>
                  <div>
                    <div class="jtv-top-cart-content"> 
                      <span class="triup glyphicon glyphicon-triangle-top" style="left: 70%"></span>
                      <!--block-subtitle-->
                      @if(count($header_data['cart_data']) > 0)
                      <ul class="mini-products-list" id="cart-sidebar">
                            @php
                                $total = 0;
                            @endphp
                            @foreach($header_data['cart_data'] as $product_id => $item)
                                <li class="item first">
                                  <div class="item-inner"> 
                                   <a class="product-image" title="{{ $item['product_name'] }}" href="#">
                                        @if($item['product_type'] == 'Metal')
                                             <img alt="{{ $item['product_name'] }}" src="{{ route('admin.metal_product_banner', ['product_id' => encrypt($item['product_id'])]) }}"> 
                                        @else
                                             <img alt="{{ $item['product_name'] }}" src="{{ route('admin.product_banner', ['product_id' => encrypt($item['product_id'])]) }}"> 
                                        @endif
                                   </a>
                                    <div class="product-details">
                                      <div class="access"><a class="jtv-btn-remove" title="Remove This Item" href="{{ route('web.remove_cart_item', ['product_id' => $item['product_id']]) }}">Remove</a></div>
                                      <p class="product-name"><a href="#" class=" line-break2">{{ $item['product_name'] }}</a> </p>
                                      <strong>{{ $item['quantity'] }}</strong> x 
                                      <span class="price">
                                        @auth('users')
                                            @if((Auth::user()->user_role == 2) && !empty(Auth::user()))
                                                @php
                                                    if (!empty($item['discount'])) {
                                                        $discount = ($item['seller_price'] * $item['discount']) / 100;
                                                        $selling_amount = $item['seller_price'] - $discount;

                                                        $sub_total = $selling_amount * $item['quantity'];
                                                    } else {

                                                        $sub_total = $item['seller_price'] * $item['quantity'];
                                                    }
                                                @endphp
                                                ₹{{ $sub_total }}
                                            @else
                                                @php
                                                    if (!empty($item['discount'])) {
                                                        $discount = ($item['price'] * $item['discount']) / 100;
                                                        $selling_amount = $item['price'] - $discount;

                                                        $sub_total = $selling_amount * $item['quantity'];
                                                    } else {

                                                        $sub_total = $item['price'] * $item['quantity'];
                                                    }
                                                @endphp
                                                ₹{{ $sub_total }}
                                            @endif
                                        @else
                                            @php
                                                if (!empty($item['discount'])) {
                                                    $discount = ($item['price'] * $item['discount']) / 100;
                                                    $selling_amount = $item['price'] - $discount;

                                                    $sub_total = $selling_amount * $item['quantity'];
                                                } else {

                                                    $sub_total = $item['price'] * $item['quantity'];
                                                }
                                            @endphp
                                            ₹{{ $sub_total }}
                                        @endif
                                    </span> </div>
                                  </div>
                                </li>
                                @auth('users')
                                    @if((Auth::user()->user_role == 2) && !empty(Auth::user()))
                                        @php
                                            if (!empty($item['discount'])) {
                                                $discount = ($item['seller_price'] * $item['discount']) / 100;
                                                $selling_amount = $item['seller_price'] - $discount;

                                                $sub_total = $selling_amount * $item['quantity'];
                                            } else {

                                                $sub_total = $item['seller_price'] * $item['quantity'];
                                            }

                                            $total = $total + $sub_total;
                                        @endphp
                                    @else
                                        @php
                                            if (!empty($item['discount'])) {
                                                $discount = ($item['price'] * $item['discount']) / 100;
                                                $selling_amount = $item['price'] - $discount;

                                                $sub_total = $selling_amount * $item['quantity'];
                                            } else {

                                                $sub_total = $item['price'] * $item['quantity'];
                                            }

                                            $total = $total + $sub_total;
                                        @endphp
                                    @endif
                                @else
                                    @php
                                        if (!empty($item['discount'])) {
                                            $discount = ($item['price'] * $item['discount']) / 100;
                                            $selling_amount = $item['price'] - $discount;

                                            $sub_total = $selling_amount * $item['quantity'];
                                        } else {

                                            $sub_total = $item['price'] * $item['quantity'];
                                        }

                                        $total = $total + $sub_total;
                                    @endphp
                                @endif
                            @endforeach
                      </ul>
                      
                      <!--actions-->
                      <div class="actions">
                        <a class="item-count">Total : ₹ {{ $total }}</a>
                        <a href="{{ route('web.view_cart') }}" class="view-cart"><span>View Cart</span></a>
                      </div>
                      @else
                        <div class="actions" style="background: #ffffff05; text-align: center;">
                          <img src="{{asset('web/images/no-product.jpg')}}" alt="">
                            Cart is Empty
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- end header --> 
    
    <!-- Navigation -->  
    <nav>
      <div class="container">
        <div class="mm-toggle-wrap">
          <div class="mm-toggle"><i class="fa fa-bars"></i><span class="mm-label">Menu</span> </div>
        </div>
        <div class="nav-inner"> 
          <!-- BEGIN NAV -->
          <ul id="nav" class="hidden-xs">
            <li><a href="{{route('web.index')}}" class="level-top active"><span>Home</span></a></li>
            {{-- <li><a href="{{route('web.extra.about')}}"> <span>About Eagle Group</span> </a> </li> --}}
            @if(!empty($header_data['categories']) && (count($header_data['categories']) > 0))
                @foreach($header_data['categories'] as $key => $item)
                <li class="drop-menu"><a class="level-top"><span>{{ $item['top_cate_name'] }}<i class="fa fa-angle-down"></i></span></a>
                  <ul>
                    @if($item['top_category_id'] == 4)
                        @if(!empty($item['sub_categories']) && (count($item['sub_categories']) > 0))
                            @foreach($item['sub_categories'] as $key_1 => $item_1)
                                <li>
                                    <a href="{{route('web.bell_brass_metal_product_list', ['slug' => $item_1->slug, 'sub_category_id' => $item_1->id])}}">
                                        <span>
                                            {{ $item_1->sub_cate_name }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    @else
                        @if(!empty($item['sub_categories']) && (count($item['sub_categories']) > 0))
                            @foreach($item['sub_categories'] as $key_1 => $item_1)
                                <li>
                                    <a href="{{route('web.product_list', ['slug' => $item_1->slug, 'sub_category_id' => $item_1->id, 'sorted_by' => 1])}}">
                                        <span>
                                            {{ $item_1->sub_cate_name }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    @endif
                  </ul>
                </li>
                @endforeach
            @endif
            @auth('users')
            <li class="drop-menu"> <a class="level-top"><span>Welcome, {{Auth::guard('users')->user()->name}} <i class="fa fa-angle-down"></i></span></a>
              <ul>
                <li><a href="{{ route('web.view_cart') }}"> <span>Cart</span> </a> </li>
                <li><a href="{{ route('web.order_history') }}"><span>My Orders</span></a> </li>
                <li><a href="{{route('web.wish_list')}}"> <span>My Wishlist</span> </a> </li>
                <li><a href="{{ route('web.logout') }}"> <span>Logout</span> </a> </li>
              </ul>
            </li>
            @else
            <li> <a class="level-top" href="{{route('web.login')}}"><span>Signin</span></a></li>
            <li> <a class="level-top" href="{{route('user.registration_page')}}"><span> Signup</span></a></li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>
    <!-- end nav --> 