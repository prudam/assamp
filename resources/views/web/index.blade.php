@extends('web.templet.master')

  @include('web.include.seo')

  @section('seo')
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="John Doe">    
  @endsection

  @section('content')
    <!-- JTV Home Slider -->
    <div class="jtv-slideshow">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div id='jtv-rev_slider_wrapper' class='rev_slider_wrapper fullwidthbanner-container'>
              <div id='jtv-rev_slider' class='rev_slider fullwidthabanner'>
                <ul>
                    @if(!empty($sliders) && (count($sliders) > 0))
                        @php
                            if(!empty($coupon) && (count($coupon) > 0)){
                              $coupon_status = true;
                            }else{
                              $coupon_status = false;
                            }
                          $coupon_count = 0;
                        @endphp
                        @for($i = 0; $i < count($sliders); $i++)
                              <li data-transition='random' data-slotamount='7' data-masterspeed='1000' data-thumb='{{ asset('assets/slider/'.$sliders[$i]->slider.'') }}'><img src="{{ asset('assets/slider/'.$sliders[$i]->slider.'') }}" alt="slide-img" data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' />
                                @if(($sliders[$i]->show_text_type =='1') && isset($coupon[$coupon_count]) && !empty($coupon[$coupon_count]) && $coupon_status)
                                <div class="info">
                                  <div class='tp-caption jtv-sub-title sft tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2;max-width:auto;max-height:auto;white-space:nowrap;'><span>COUPON CODE</span> </div>
                                  <div class='tp-caption jtv-large-title sfl tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3;max-width:auto;max-height:auto;white-space:nowrap;'><span>{{ $coupon[$coupon_count]->coupon_code }}</span> </div>
                                  <div class='tp-caption Title sft tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1450' data-easing='Power2.easeInOut' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;font-size: 18px'>{{ $coupon[$coupon_count]->coupon_desc }}</div>
                                  <div class='tp-caption sfb  tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;'> </div>
                                </div>
                                @php
                                    $coupon_count++;
                                @endphp
                                @else
                                  <div class="info">
                                    <div class='tp-caption jtv-sub-title sft tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2;max-width:auto;max-height:auto;white-space:nowrap;'><span>{{$sliders[$i]->other_title}}</span> </div>
                                    <div class='tp-caption jtv-large-title sfl tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3;max-width:auto;max-height:auto;white-space:nowrap;'><span>{{$sliders[$i]->bold_text}}</span> </div>
                                    <div class='tp-caption Title sft tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1450' data-easing='Power2.easeInOut' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;font-size: 18px'>{{$sliders[$i]->description}}</div>
                                    <div class='tp-caption sfb  tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;'> </div>
                                  </div>
                                @endif
                              </li>
                              {{-- <li data-transition='random' data-slotamount='7' data-masterspeed='1000' data-thumb='{{ asset('assets/slider/'.$sliders[$i]->slider.'') }}'><img src="{{ asset('assets/slider/'.$sliders[$i]->slider.'') }}" alt="slide-img" data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' />
                              <div class="info">
                                <div class='tp-caption jtv-sub-title sft tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2;max-width:auto;max-height:auto;white-space:nowrap;'><span></span> </div>
                                <div class='tp-caption jtv-large-title sfl tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3;max-width:auto;max-height:auto;white-space:nowrap;'><span></span> </div>
                                <div class='tp-caption Title sft tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1450' data-easing='Power2.easeInOut' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;font-size: 18px'></div>
                                <div class='tp-caption sfb  tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4;max-width:auto;max-height:auto;white-space:nowrap;'> </div>
                              </div>
                            </li>  --}}
                        @endfor
                    @endif
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- end JTV Home Slider --> 

          
        </div>
      </div>
    </div>  

    <!-- our features -->
    {{-- <div class="our-features-box hidden-xs">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-xs-12 col-sm-6">
            <div class="feature-box first"> <i class="icon-plane icons"></i>
              <div class="content">
                <h3>Delivery Available Throughout India</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-xs-12 col-sm-6">
            <div class="feature-box"> <i class="icon-earphones-alt icons"></i>
              <div class="content">
                <h3>Support 24/7 For Clients</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-xs-12 col-sm-6">
            <div class="feature-box"> <i class="icon-like icons"></i>
              <div class="content">
                <h3>100% Satisfaction Guarantee</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-xs-12 col-sm-6">
            <div class="feature-box last"> <i class="icon-tag icons"></i>
              <div class="content">
                <h3>Great Daily Deals Discount</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}

    <!-- Upsell Product Slider -->
    
    <div class="container">
      <div class="upsell-section">
        <div class="slider-items-products">
          <div class="upsell-block">
            <div class="jtv-block-inner">
              <div class="block-title">
                <h2>{{ $index_data->sliding_product_writeup }}</h2>
              </div>
            </div>
            <div id="upsell-products-slider" class="product-flexslider hidden-buttons">
              <div class="slider-items slider-width-col4 products-grid block-content">
                  @if(!empty($feature_product_record) && (count($feature_product_record) > 0))
                @foreach($feature_product_record as $item)
                <div class="item">
                  <div class="item-inner">
                    <div class="item-img">
                      <div class="item-img-info"> 
                        @if($item['product_type'] == 1)
                          <a href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" class="product-image" title="{{ $item['product_name'] }}" target="_blank"> <img alt="{{ $item['product_name'] }}" src="{{$item['url']}}"> </a>
                        @else
                          <a href="{{route('web.bell_brass_metal_product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" class="product-image" title="{{ $item['product_name'] }}" target="_blank"> <img alt="{{ $item['product_name'] }}" src="{{$item['url']}}"> </a>
                        @endif
                      </div>
                    </div>
                    <div class="item-info">
                      <div class="info-inner">
                        <div class="item-title"> 
                          @if($item['product_type'] == 1)
                            <a title="{{ $item['product_name'] }}" href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" target="_blank"> {{ $item['product_name'] }} </a> 
                          @else
                            <a title="{{ $item['product_name'] }}" href="{{route('web.bell_brass_metal_product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" target="_blank"> {{ $item['product_name'] }} </a> 
                          @endif
                        </div>
                        <div class="item-content">
                          <div class="item-price">
                            <div class="price-box"> 
                              <span class="regular-price"> 
                                <span class="price">
                                   @auth('users')
                                        @if((Auth::user()->user_role == 2) && !empty(Auth::user()))
                                            @if(!empty($item['discount']))
                                                ₹{{ $item['seller_price'] }}
                                            @endif
                                            @php
                                            $price = $item['seller_price'];
                                            @endphp
                                        @else
                                            @if(!empty($item['discount']))
                                                ₹{{ $item['price'] }}
                                            @endif
                                            @php
                                            $price = $item['price'];
                                            @endphp
                                        @endif
                                    @else
                                        @if(!empty($item['discount']))
                                            ₹{{ $item['price'] }}
                                        @endif
                                        @php
                                        $price = $item['price'];
                                        @endphp
                                    @endif
                                </span>
                                @php

                                if (!empty($item['discount'])) {

                                    $discount = (($price * $item['discount']) / 100);
                                    $selling_price = $price - $discount;
                                } else
                                    $selling_price = $price;
                                @endphp

                                {{ $selling_price }}
                              </span> 
                            </div>
                          </div>
                          <div class="action">
                            <a class="link-wishlist" href="{{ route('web.add_wish_list', ['product_id' => $item['id']]) }}"><i class="icon-heart icons"></i><span class="hidden">Wishlist</span></a>

                            @if($item['product_type'] == 1)
                              <a href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" class="button btn-cart" title="{{ $item['product_name'] }}" data-original-title="View detail" target="_blank"><span>View detail</span> </a>
                            @else
                            <a href="{{route('web.bell_brass_metal_product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" class="button btn-cart" title="{{ $item['product_name'] }}" data-original-title="View detail" target="_blank"><span>View detail</span> </a>
                            @endif
                          </div>
                        </div>
                      </div>
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

    <!-- Banner 1 -->
    <div class="jtv-top-banner">
      <div class="container">
        <div class="imgbox"><img src="{{asset('assets/footer/'.$index_data->footer_first_banner.'')}}" alt=""></div>
        <div class="jtv-cont-box" style="color: @php print !empty($index_data->footer_banner_word_color)? $index_data->footer_banner_word_color: "black"; @endphp;background: @php print !empty($index_data->footer_banner_background_color)? $index_data->footer_banner_background_color: "red"; @endphp">
          {!! $index_data->footer_banner_writeup !!}
        </div>
        <div class="imgbox"><img src="{{asset('assets/footer/'.$index_data->footer_second_banner.'')}}" alt=""></div>
      </div>
    </div>

     <!-- Special Product slider -->  
    {{-- <section class="special-products">
      <div class="container">
        <div class="jtv-title" style="margin-bottom: 15px;">
          <h2>Top Selling Products</h2>
        </div>
        <div class="slider-items-products">
          <div class="jtv-special-block">
            <div class="jtv-block-inner">
              <div class="block-title">
                <h2 class="jststyle">TOP SELLING PRODUCTS</h2>
              </div>
            </div>
            <div id="special-slider" class="product-flexslider hidden-buttons">
              <div class="slider-items slider-width-col4 products-grid block-content">
                @if(!empty($best_seller_product_record) && (count($best_seller_product_record) > 0))
                    @foreach($best_seller_product_record as $item)
                    <div class="item">
                      <div class="item-inner">
                        <div class="item-img">
                          <div class="item-img-info"> <a class="product-image" title="{{ $item['product_name'] }}" href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" target="_blank"> <img alt="{{ $item['product_name'] }}" src="{{ $item['url'] }}"> </a>
                          </div>
                        </div>
                        <div class="item-info">
                          <div class="info-inner">
                            <div class="item-title"> <a title="{{ $item['product_name'] }}" href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" target="_blank"> {{ $item['product_name'] }} </a> </div>
                            <div class="item-content">
                              <div class="item-price">
                                <div class="price-box"> 
                                  <span class="regular-price"> 
                                    <span class="price">
                                       @auth('users')
                                            @if((Auth::user()->user_role == 2) && !empty(Auth::user()))
                                                ₹{{ $item['seller_price'] }}
                                                @php
                                                $price = $item['seller_price'];
                                                @endphp
                                            @else
                                                ₹{{ $item['price'] }}
                                                @php
                                                $price = $item['price'];
                                                @endphp
                                            @endif
                                        @else
                                            ₹{{ $item['price'] }}
                                            @php
                                            $price = $item['price'];
                                            @endphp
                                        @endif
                                    </span>
                                    @php
                                    $discount = (($price * $item['discount']) / 100);
                                    $selling_price = $price - $discount;
                                    @endphp

                                    {{ $selling_price }}
                                  </span> 
                                </div>
                              </div>
                              <div class="action">
                                <a class="link-wishlist" href="wishlist.html"><i class="icon-heart icons"></i><span class="hidden">Wishlist</span></a>
                                <a href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" class="button btn-cart" title="{{ $item['product_name'] }}" data-original-title="View detail"><span>View detail</span> </a>
                              </div>
                            </div>
                          </div>
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
    </section> --}}
    
    <!-- bestsell Slider -->
    {{-- <div class="content-page">
      <div class="container"> 
        <!-- Product Tabs-->
        <div class="category-product">
          <div class="navbar nav-menu">
            <div class="navbar-collapse">
              <div class="jtv-title">
                <h2>Featured Products</h2>
              </div>
              <ul class="nav navbar-nav">
                <li class="active"><a data-toggle="tab" href="#tab-1">Mekhela Chadar</a> </li>
                <li><a data-toggle="tab" href="#tab-2">Saree</a> </li>
                <li><a data-toggle="tab" href="#tab-3">Kurti</a> </li>
              </ul>
            </div>
            <!-- /.navbar-collapse -->           
          </div>
          <div class="tab-container"> 
            <!-- tab product -->
            @if(!empty($feature_product_record) && (count($feature_product_record) > 0))
            <div class="tab-panel active" id="tab-1">
                @if(!empty($feature_product_record[0]['first_category_product_record']) && (count($feature_product_record[0]['first_category_product_record']) > 0))
                  <div class="category-products">
                    <ul class="products-grid">
                        @foreach($feature_product_record[0]['first_category_product_record'] as $item)
                      <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <div class="item-inner">
                          <div class="item-img">
                            <div class="item-img-info"> <a class="product-image" title="{{ $item['product_name'] }}" href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}"> <img alt="{{ $item['product_name'] }}" src="{{ $item['url'] }}"> </a>
                            </div>
                          </div>
                          <div class="item-info">
                            <div class="info-inner">
                              <div class="item-title"> 
                                <a title="{{ $item['product_name'] }}" href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}"> {{ $item['product_name'] }} </a>
                              </div>
                              <div class="item-content">
                                <div class="item-price">
                                  <span class="regular-price"> 
                                      <span class="price">
                                        @auth('users')
                                              @if((Auth::user()->user_role == 2) && !empty(Auth::user()))
                                                  ₹{{ $item['seller_price'] }}
                                                  @php
                                                  $price = $item['seller_price'];
                                                  @endphp
                                              @else
                                                  ₹{{ $item['price'] }}
                                                  @php
                                                  $price = $item['price'];
                                                  @endphp
                                              @endif
                                        @else
                                              ₹{{ $item['price'] }}
                                              @php
                                              $price = $item['price'];
                                              @endphp
                                        @endif
                                      </span>
                                    @php
                                    $discount = (($price * $item['discount']) / 100);
                                    $selling_price = $price - $discount;
                                    @endphp
                                    {{ $selling_price }}
                                  </span> 
                                </div>
                              </div>
                              <div class="action">
                                <a class="link-wishlist" href="wishlist.html"><i class="icon-heart icons"></i><span class="hidden">Wishlist</span></a>
                                <a href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" class="button btn-cart" title="{{ $item['product_name'] }}" data-original-title="View detail"><span>View detail</span> </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                  </div>
              @endif
            </div>
            <!-- tab product -->
            <div class="tab-panel" id="tab-2">
                @if(!empty($feature_product_record[0]['second_category_product_record']) && (count($feature_product_record[0]['second_category_product_record']) > 0))
              <div class="category-products">
                <ul class="products-grid">
                     @foreach($feature_product_record[0]['second_category_product_record'] as $item)
                      <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <div class="item-inner">
                          <div class="item-img">
                            <div class="item-img-info"> <a class="product-image" title="{{ $item['product_name'] }}" href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}"> <img alt="{{ $item['product_name'] }}" src="{{ $item['url'] }}"> </a>
                            </div>
                          </div>
                          <div class="item-info">
                            <div class="info-inner">
                              <div class="item-title"> <a title="{{ $item['product_name'] }}" href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}"> {{ $item['product_name'] }} </a> </div>
                              <div class="item-content">
                                  <div class="item-price">
                                    <div class="price-box">
                                      <span class="regular-price"> 
                                      <span class="price">
                                        @auth('users')
                                              @if((Auth::user()->user_role == 2) && !empty(Auth::user()))
                                                  ₹{{ $item['seller_price'] }}
                                                  @php
                                                  $price = $item['seller_price'];
                                                  @endphp
                                              @else
                                                  ₹{{ $item['price'] }}
                                                  @php
                                                  $price = $item['price'];
                                                  @endphp
                                              @endif
                                        @else
                                              ₹{{ $item['price'] }}
                                              @php
                                              $price = $item['price'];
                                              @endphp
                                        @endif
                                      </span>
                                    @php
                                    $discount = (($price * $item['discount']) / 100);
                                    $selling_price = $price - $discount;
                                    @endphp
                                    {{ $selling_price }}
                                  </span> 
                                    </div>
                                  </div>
                                  <div class="action">
                                    <a class="link-wishlist" href="wishlist.html"><i class="icon-heart icons"></i><span class="hidden">Wishlist</span></a>
                                    <a href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" class="button btn-cart" title="{{ $item['product_name'] }}" data-original-title="View detail"><span>View detail</span> </a>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      @endforeach
                </ul>
              </div>
                @endif
            </div>
            <div class="tab-panel" id="tab-3">
                @if(!empty($feature_product_record[0]['third_category_product_record']) && (count($feature_product_record[0]['third_category_product_record']) > 0))
              <div class="category-products">
                <ul class="products-grid">
                   @foreach($feature_product_record[0]['third_category_product_record'] as $item)
                      <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <div class="item-inner">
                          <div class="item-img">
                            <div class="item-img-info"> <a class="product-image" title="{{ $item['product_name'] }}" href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}"> <img alt="{{ $item['product_name'] }}" src="{{ $item['url'] }}"> </a>
                            </div>
                          </div>
                          <div class="item-info">
                            <div class="info-inner">
                              <div class="item-title"> <a title="{{ $item['product_name'] }}" href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}"> {{ $item['product_name'] }} </a> </div>
                              <div class="item-content">
                                  <div class="item-price">
                                    <div class="price-box">
                                      <span class="regular-price"> 
                                      <span class="price">
                                        @auth('users')
                                              @if((Auth::user()->user_role == 2) && !empty(Auth::user()))
                                                  ₹{{ $item['seller_price'] }}
                                                  @php
                                                  $price = $item['seller_price'];
                                                  @endphp
                                              @else
                                                  ₹{{ $item['price'] }}
                                                  @php
                                                  $price = $item['price'];
                                                  @endphp
                                              @endif
                                        @else
                                              ₹{{ $item['price'] }}
                                              @php
                                              $price = $item['price'];
                                              @endphp
                                        @endif
                                      </span>
                                    @php
                                    $discount = (($price * $item['discount']) / 100);
                                    $selling_price = $price - $discount;
                                    @endphp
                                    {{ $selling_price }}
                                  </span> 
                                    </div>
                                  </div>
                                  <div class="action">
                                    <a class="link-wishlist" href="wishlist.html"><i class="icon-heart icons"></i><span class="hidden">Wishlist</span></a>
                                    <a href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['id']])}}" class="button btn-cart" title="{{ $item['product_name'] }}" data-original-title="View detail"><span>View detail</span> </a>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      @endforeach
                </ul>
              </div>
                @endif
            </div>
            @endif
        </div>
          </div>
        </div>
      </div>
    </div> --}}

    <!-- Banner 2 -->
    {{-- <div class="jtv-top-banner">
      <div class="container">
        <div class="jtv-cont-box2">
          <h3>Designer <br>
            Collection</h3>
          <div class="jtv-line-bg"></div>
          <p>Treanding styles of 2020 with traditional look .adipiscing elit, sed.</p>
        </div>
        <div class="imgbox"><img src="{{asset('web/images/banner3.jpg')}}" alt=""></div>
        <div class="jtv-cont-box3">
          <h3>fashion <br>
            2020</h3>
          <div class="jtv-line-bg"></div>
          <p>adipiscing elit, sed do consectetur adipiscing elit, sed do eiusmod.</p>
        </div>
      </div>
    </div>  --}}     
    
    <!-- Brand Logo -->  
    <div class="brand-logo">
      <div class="container">
        <div class="slider-items-products">
          <div id="brand-logo-slider" class="product-flexslider hidden-buttons" style="display: none;">
            <div class="slider-items slider-width-col6"> 
              
              <!-- Item -->
              <div class="item"> <a href="#"><img src="{{asset('web/images/brand3.png')}}" alt="Image"> </a> </div>
              <!-- End Item --> 
              
              <!-- Item -->
              <div class="item"> <a href="#"><img src="{{asset('web/images/brand1.png')}}" alt="Image"> </a> </div>
              <!-- End Item --> 
              
              <!-- Item -->
              <div class="item"> <a href="#"><img src="{{asset('web/images/brand2.png')}}" alt="Image"> </a> </div>
              <!-- End Item --> 
              
              <!-- Item -->
              <div class="item"> <a href="#"><img src="{{asset('web/images/brand4.png')}}" alt="Image"> </a> </div>
              <!-- End Item --> 
              
              <!-- Item -->
              <div class="item"> <a href="#"><img src="{{asset('web/images/brand5.png')}}" alt="Image"> </a> </div>
              <!-- End Item --> 
              
              <!-- Item -->
              <div class="item"> <a href="#"><img src="{{asset('web/images/brand6.png')}}" alt="Image"> </a> </div>
              <!-- End Item --> 
              
              <!-- Item -->
              <div class="item"> <a href="#"><img src="{{asset('web/images/brand2.png')}}" alt="Image"> </a> </div>
              <!-- End Item --> 
              
              <!-- Item -->
              <div class="item"> <a href="#"><img src="{{asset('web/images/brand4.png')}}" alt="Image"> </a> </div>
              <!-- End Item --> 
              
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection

@section('script')
  <script type="text/javascript">
    $(document).ready(function(){
        $('#search').keyup(function(){
            var keyword = $('#search').val();

            if (keyword.length == 0) {
                $('#livesearch').hide();
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });

                $.ajax({
                    method: "GET",
                    url   : "{{ url('/product-search/') }}/"+keyword,
                    success: function(response) {

                        if (response == ""){

                          
                               $('#livesearch').html("<div style='background: #ffffff05; text-lign: center;'><img src='{{asset('web/images/not-found.jpg')}}' style='max-width: 100%'><strong>Sorry !!</strong> couldn\'t find what your are looking for...</div>");
                        }
                        else
                            $('#livesearch').html(response);

                        $('#livesearch').show();
                    }
                });
            }
        });
    });
  </script>
@endsection