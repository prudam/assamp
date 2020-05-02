  @extends('web.templet.master')

  @include('web.include.seo')

  @section('seo')
    <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript">
  <meta name="author" content="John Doe">
      
  @endsection

  @section('content')
  <!-- end nav --> 
  
  <section class="main-container col1-layout">
    <div class="main container cart-pad">
      <div class="col-main">
        <div class="shopping-cart-inner">
          <div class="page-content">
           {{--  @if(count($cart_data) > 0) --}}
                <div class="order-detail-content myorder">
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      {{-- ORDER1 --}}
                        @if(!empty($order_history) && (count($order_history) > 0))
                            @foreach ($order_history as $key => $item)
                                @if(!empty($item['order_detail']))
                              <div class="row singleorder">
                                <div class="row">
                                  <div class="col-md-12 singleorderid">
                                    <h5><strong>Orders ID: {{ $item['order_id'] }}</strong></h5>
                                    <p style="margin-bottom:0">Order Date: {{ $item['order_date'] }}</p> 
                                    <h5 class="status" style="margin-top:0">Order Status: <span style="color: #07bdbd;">{{ $item['order_status'] }}</span></h5>
                                  </div>
                                </div>
                                @php
                                    $cash_on_delivery = 0;
                                @endphp
                                @foreach($item['order_detail'] as $key_1 => $item_1)
                                <div class="row">
                                  <div class="col-md-2 singleorderimg">
                                    <a href="#"><img src="{{ asset('assets/product/banner/'.$item_1['banner'].'') }}" alt=""></a>
                                  </div>
                                  <div class="col-md-10 singleordercontent">
                                    @if($item_1['product_type'] == 1)
                                      @if(empty($item_1['deleted_at']))
                                        <a href="{{ route('web.product_detail', ['slug' => $item_1['slug'], 'product_id' => $item_1['product_id']]) }}" target="_blank">{{ $item_1['product_name'] }}</a><br>
                                      @else
                                        <a>{{ $item_1['product_name'] }}</a><br>
                                      @endif
                                    <b class="sub-tag spl">Product Type : Ready to wear</b> 
                                    @elseif($item_1['product_type'] == 2)
                                      @if(empty($item_1['deleted_at']))
                                        <a href="{{ route('web.product_detail', ['slug' => $item_1['slug'], 'product_id' => $item_1['product_id']]) }}" target="_blank">{{ $item_1['product_name'] }}</a><br>
                                      @else
                                        <a>{{ $item_1['product_name'] }}</a><br>
                                      @endif
                                    <b class="sub-tag spl">Product Type : Raw</b> 
                                    @elseif($item_1['product_type'] == 3)
                                      @if(empty($item_1['deleted_at']))
                                        <a href="{{ route('web.bell_brass_metal_product_detail', ['slug' => $item_1['slug'], 'product_id' => $item_1['product_id']]) }}" target="_blank">{{ $item_1['product_name'] }}</a><br>
                                      @else
                                        <a>{{ $item_1['product_name'] }}</a><br>
                                      @endif
                                    @endif
                                    <p class="quantity">Quantity: {{ $item_1['quantity'] }}</p>
                                    <div class="cart-price" style="text-align: left;">                           
                                      <span class="cancel-price">
                                        @php
                                        if (!empty($item_1['discount'])) {

                                            print "₹".$item_1['rate'];

                                           $discount = ($item_1['rate'] * $item_1['discount']) / 100;
                                           $selling =  $item_1['rate'] -$discount; 
                                        } else {
                                          $selling =  $item_1['rate'];
                                        }
                                        @endphp
                                      </span>
                                      <span>
                                        ₹{{ $selling }}
                                      </span>
                                    </div>
                                    Total: {{ $selling*$item_1['quantity'] }}
                                  </div>                        
                                </div>
                                @endforeach

                                <div class="row">
                                  <div class="col-md-12 totalordercontent"> 
                                    @php
                                    $total = $item['amount'];
                                    @endphp
                                    <h5>Total: Rs {{ $total }}</h5> 
                                    @php
                                    if (!empty($item['coupon_amount'])) {
                                        
                                        $coupon_discount = ($item['amount'] * $item['coupon_amount']) / 100;
                                        $total = $total - $coupon_discount;
                                    } else { 
                                        $total = $item['amount'];
                                    }

                                    if (!empty($item['shipping_amount'])) {
                                        $total = $total + $item['shipping_amount'];
                                    }
                                    @endphp
                                    @if(!empty($item['shipping_amount']))
                                    <h5>CoD Commission: Rs {{ $item['shipping_amount'] }}</h5>  
                                    @endif   
                                    @if(!empty($item['coupon_amount']))
                                    <h5>Coupon: {{ $coupon_discount }}</h5>  
                                    @endif
                                    <h5>Grand Total: Rs {{ $total }}</h5> 
                                  </div>                         
                                </div>
                              </div>
                              @endif
                            @endforeach
                        @else    
                          <center>
                            <div class="emptycrt">
                              <img src="http://localhost/assam_products/public/web/images/no-product.jpg" alt="">
                                <p style="margin: 10px 0 0">No Order Placed Yet </p>
                            </div>
                          </center>
                        @endif

                    </div>
                  </div>

                  <div class="cart_navigation" style="display: flex;justify-content: center;">
                    <a class="button continue-shopping" href="{{ route('web.index') }}" title="Continue shopping"><span>Continue shopping</span></a>
                  </div>
                </div>
            {{-- @else
            <center>
                Shopping Cart is empty.
            </center>
            @endif --}}
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Footer -->
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