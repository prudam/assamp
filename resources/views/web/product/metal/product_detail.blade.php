  @extends('web.templet.master')

@section('seo')
    <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript">
  <meta name="author" content="John Doe">
        
  @endsection

  @section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <ul>
                <li class="home"> <a href="{{ route('web.index') }}" title="Go to Home Page">Home</a> <span>/</span> </li>
                <li> <a title="">Clutches</a> <span>/ </span> </li>
                <li> <a title="">Bucket Bag</a> <span>/</span> </li>
                <li> <strong>Lorem ipsum dolor sit amet</strong> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    <!-- Breadcrumbs End --> 
    
     <!-- Main Container -->
     <section class="main-container col1-layout">
        <div class="main">
          <div class="container">
            <div class="row">
              <div class="col-main">
                <div class="product-view">
                  <div class="product-essential">
                    <div class="product-img-box col-lg-4 col-sm-6 col-xs-12">
                      <div class="new-label new-top-left"> New </div>
                      <div class="product-image">
                      <div class="product-full"> <img id="product-zoom" src="{{asset('assets/product/banner/'.$product_detail->banner)}}" data-zoom-image="{{asset('assets/product/banner/'.$product_detail->banner)}}" alt="product-image"/> </div>
                      <div class="more-views">
                        <div class="slider-items-products">
                          <div id="gallery_01" class="product-flexslider hidden-buttons product-img-thumb">
                            <div class="slider-items slider-width-col4 block-content">
                              <div class="more-views-items"> <a href="#" data-image="{{asset('assets/product/banner/'.$product_detail->banner)}}" data-zoom-image="{{asset('assets/product/banner/'.$product_detail->banner)}}"> <img id="product-zoom"  src="{{asset('assets/product/banner/'.$product_detail->banner)}}" alt="product-image"/> </a></div>
                              @if(!empty($product_slider_images) && (count($product_slider_images) > 0))
                                @foreach($product_slider_images as $key => $item)
                                    <div class="more-views-items"> <a href="#" data-image="{{asset('assets/product/images/'.$item->additional_image)}}" data-zoom-image="{{asset('assets/product/images/'.$item->additional_image)}}"> <img id="product-zoom"  src="{{asset('assets/product/images/'.$item->additional_image)}}" alt="product-image"/> </a></div>
                                @endforeach
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      <!-- end: more-images --> 
                    </div>
                    <div class="product-shop col-lg-8 col-sm-6 col-xs-12">
                      <div class="product-name">
                        <h1>{{ $product_detail->product_name }}</h1>
                      </div>
                      <div class="price-block">
                        <div class="price-box">
                            @auth('users')
                                @if((Auth::user()->user_role == 2) && !empty(Auth::user()))
                                    @php
                                    $selling_price  = $product_detail->distributor_price;
                                    if (!empty($product_detail->discount)) {
                                        $discount = ($product_detail->distributor_price * $product_detail->discount) / 100;
                                        $selling_price  = $product_detail->distributor_price - $discount;
                                    }

                                    $price = $product_detail->distributor_price;
                                    @endphp
                                @else
                                    @php
                                    $selling_price  = $product_detail->customer_price;
                                    if (!empty($product_detail->discount)) {
                                        $discount = ($product_detail->customer_price * $product_detail->discount) / 100;
                                        $selling_price  = $product_detail->customer_price - $discount;
                                    }

                                    $price = $product_detail->customer_price;
                                    @endphp
                                @endif
                            @else
                                @php
                                $selling_price  = $product_detail->customer_price;
                                if (!empty($product_detail->discount)) {
                                    $discount = ($product_detail->customer_price * $product_detail->discount) / 100;
                                    $selling_price  = $product_detail->customer_price - $discount;
                                }
                                $price = $product_detail->customer_price;
                                @endphp
                            @endif
                            <p class="special-price"> <span class="price-label">Special Price</span> <span id="product-price-48" class="price"> ₹{{ $selling_price }} </span> </p>
                            @if(!empty($product_detail->discount))
                            <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price" id="original_price"> ₹{{ $price }} </span> </p>
                            @endif
                          </div>
                      </div>
                      <div class="info-orther">
                        <p>Availability: <span class="in-stock">
                            @if($product_detail->stock > 0)
                                In stock
                            @else
                                Out of Stock
                            @endif
                        </span></p>
                      </div>
                      @if (session()->has('msg'))
                          <span style="color: red;">{{session()->get('msg')}}</span>
                      @endif
                      <form action="{{ route('web.add_cart') }}" method="POST" autocomplete="off">
                        @csrf
                      <div class="form-option">
                        <div class="add-to-box">
                          <div class="add-to-cart">
                            <div class="pull-left">
                              <div class="custom pull-left">
                                <label>Qty :</label>
                                <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="fa fa-minus">&nbsp;</i></button>
                                <input type="text" class="input-text qty" title="Qty" value="1" maxlength="12" id="qty" name="quantity">
                                <button onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="increase items-count" type="button"><i class="fa fa-plus">&nbsp;</i></button>
                              </div>
                            </div>
                            <ul class="add-to-links">
                              <li> <a class="link-wishlist" href="{{ route('web.add_wish_list', ['product_id' => $product_detail->id]) }}"><span>Add to Wishlist</span></a></li>
                            </ul>
                            @if($product_detail->stock > 0)
                                <input type="hidden" name="product_id" value="{{ $product_detail->id }}" required>
								<input type="hidden" name="product_type" value="3" required>
								<input type="hidden" name="product_price" value="{{ $price }}" required>
                                <button class="button btn-cart" type="submit" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>
                                </form>
                            @else
                                <button class="button btn-cart" type="button"><span>Out of Stock</span></button>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="product-collateral col-lg-12 col-sm-12 col-xs-12">
                <div class="add_info">
                  <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                    <li class="active"> <a href="#product_tabs_description" data-toggle="tab"> Product Description </a> </li>
                  </ul>
                  <div id="productTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="product_tabs_description">
                      <div class="std">
                        {!! $product_detail->desc !!}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Main Container End --> 
    
    

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

                        if (response == "")
                               $('#livesearch').html("<div style='background: #ffffff05; text-lign: center;'><img src='{{asset('web/images/not-found.jpg')}}' style='max-width: 100%'><strong>Sorry !!</strong> couldn\'t find what your are looking for...</div>");
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
