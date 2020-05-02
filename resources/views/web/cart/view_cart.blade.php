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
            @if(count($cart_data) > 0)
                <ul class="step">
                  <li class="current-step done-step new"><span>Summary</span></li>
                  @auth
                   <li><span>Sign Out</span></li>
                  @else
                  <li><span>Sign in</span></li>
                  @endauth
                  <li><span>Checkout</span></li>
                  <li><span>Order Corfirmation</span></li>
                </ul>
                <div class="heading-counter warning">Your shopping cart contains: 
                    <span>
                        {{ count($cart_data) }} Product
                    </span> 
                </div>
                @if (session()->has('msg'))
                    <span style="color:red">{{session()->get('msg')}}</span>
                @endif
                <div class="order-detail-content">
                    <form method="POST" action="{{ route('web.update_cart') }}" autocomplete="off">
                        @csrf
                  <table class="table table-bordered table-responsive jtv-cart-summary">
                    <thead>
                      <tr>
                        <th class="cart_product">Product</th>
                        <th>Description</th>
                        <th>Unit price</th>
                        <th>Qty</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach($cart_data as $product_id => $item)
                      <tr>
                        <td class="cart_product">
                            @if ($item['product_type'] == 'Metal')
                            <a href="{{route('web.bell_brass_metal_product_detail', ['slug' => $item['slug'], 'product_id' => $item['product_id']])}}" class="" title="{{ $item['product_name'] }}" target="_blank">
                                <img src="{{ route('admin.metal_product_banner', ['product_id' => encrypt($item['product_id'])]) }}" alt="{{ $item['product_name'] }}">
                            </a>
                            @else
                            <a href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['product_id']])}}" class="" title="{{ $item['product_name'] }}" target="_blank">
                                <img src="{{ route('admin.product_banner', ['product_id' => encrypt($item['product_id'])]) }}" alt="{{ $item['product_name'] }}">
                            </a>
                            @endif
                        </td>
                        <td class="cart_description">
                            @if ($item['product_type'] == 'Metal')
                                <a href="{{route('web.bell_brass_metal_product_detail', ['slug' => $item['slug'], 'product_id' => $item['product_id']])}}" title="{{ $item['product_name'] }}" target="_blank" class="product-name  line-break3">
                                    {{ $item['product_name'] }} 
                                </a>
                            @else
                                <a href="{{route('web.product_detail', ['slug' => $item['slug'], 'product_id' => $item['product_id']])}}" title="{{ $item['product_name'] }}" target="_blank" class="product-name  line-break3">
                                    {{ $item['product_name'] }} 
                                </a>
                            @endif
                            @if ($item['product_type'] != 'Metal')
                              <b class="sub-tag">Product Type : {{ $item['product_type'] }}</b><br>
                            @endif
                            <a href="{{ route('web.remove_cart_item', ['product_id' => $item['product_id']]) }}" class="button" style="margin-top: 5px">Remove item</a>  
                        </td>
                        <td class="cart-price">                            
                            <span class="cancel-price">
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
                            <span>
                              @php
                                        $discount = (($price * $item['discount']) / 100);
                                        $selling_price = $price - $discount;
                                        @endphp

                                        {{ $selling_price }}
                            </span>
                        </td>
                        <td class="qty">{{-- 
                          <button onClick="var result = document.getElementById('qty2'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) result.value--;return false;" class="reduced items-count" type="button"><i class="fa fa-minus">&nbsp;</i></button> --}}
                          <input type="text" class="input-text qty" min="1" title="Qty" maxlength="12" id="qty2" name="quantity[]" value="{{  $item['quantity'] }}">
                       {{--    <button onClick="var result = document.getElementById('qty2'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="increase items-count" type="button"><i class="fa fa-plus">&nbsp;</i></button> --}}
                        </td>
                        <td class="price">
                            <span>
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

                                ₹{{ $sub_total }}
                            </span>
                            <input type="hidden" name="product_id[]" value="{{ $item['product_id'] }}">
                        </td>
                      </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2" style="text-align: center;">
                          <button type="submit" class="button btn-primary" title="update Cart" style="margin-top: 5px;background: #394771;color: #fff; border: 0">Update Cart</button>  </td>
                        <td colspan="2">Grand Total (tax incl.)</td>
                        <td colspan="1">₹{{ $total }}</td>
                      </tr>
                    </tfoot>
                  </table>
              </form>
                  <div class="cart_navigation">
                    <a class="button continue-shopping" href="{{ route('web.index') }}" title="Continue shopping"><span>Continue shopping</span></a>
                    
                    <a href="{{ route('web.checkout') }}" class="button btn-proceed-checkout" title="Proceed to Checkout" ><span>Proceed to Checkout</span></a>
                  </div>
                </div>
            @else
              <center>
                <div class="emptycrt">
                  <img src="http://localhost/assam_products/public/web/images/no-product.jpg" alt="">
                    <p style="margin: 10px 0 0">Cart is Empty</p>
                </div>
              </center>
            @endif
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