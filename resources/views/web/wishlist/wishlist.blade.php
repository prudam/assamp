  @extends('web.templet.master')

  @include('web.include.seo')

  @section('seo')
    <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript">
  <meta name="author" content="John Doe">
      


  {{-- CSS Style For Customization --}}
    <style>
    .header-container, nav, .footer-top {background: @php print $header_color->header_middle_color @endphp;}/*---- Header Middle ----*/
    .jtv-top-links .links li a, .welcome-msg, #nav li a, footer address p, footer .footer-top a {color: @php print $header_color->header_word_color @endphp;}/*---- Header & Footer All Writeup ----*/
    .header-top, #nav {background-color:  @php print $header_color->header_top_color @endphp;}/*---- Header top, boottom, footer-top ----*/
    /*---- Mobile Sidebar Logo ----*/
    .jtv-search-mob .logo{background: #394771;padding: 0;margin: 0;border-radius: 10px;} 
    .jtv-search-mob .logo img{width: 100%;}
    /*---- //Mobile Sidebar Logo ----*/

  </style>
  @endsection

  @section('content')
  <!-- end nav --> 
  @if (!empty($wishlist) && (count($wishlist) > 0))
  <section class="main-container col1-layout">
    <div class="main container">
      <div class="col-main">
        <div class="shopping-cart-inner">
          <div class="page-title">
            <h2>Shopping Wishlist</h2>
          </div>
          <div class="page-content">
            <div class="order-detail-content">
              <table class="table table-bordered table-responsive jtv-cart-summary">
                <thead>
                  <tr>
                    <th class="cart_product">Image</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($wishlist as $key => $item)
                    <tr>
                      <td class="cart_product">
                        @if($item->product_type == 1)
                        <a href="{{ route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"><img src="{{ asset('assets/product/banner/'.$item->banner) }}" alt="Product"></a>
                        @else
                        <a href="{{ route('web.bell_brass_metal_product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"><img src="{{ asset('assets/product/banner/'.$item->banner) }}" alt="Product"></a>
                        @endif
                      </td>
                      <td class="cart_description">
                        <p class="product-name">
                          @if($item->product_type == 1)
                            <a href="{{ route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"> {{ $item->product_name }} </a>
                          @else
                            <a href="{{ route('web.bell_brass_metal_product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}"> {{ $item->product_name }} </a>
                          @endif
                        </p>
                      <td class="price">
                        @if($item->product_type == 1)
                        <a class="button login" href="{{ route('web.product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}">View Product</a>
                        @else
                        <a class="button login" href="{{ route('web.bell_brass_metal_product_detail', ['slug' => $item->slug, 'product_id' => $item->id]) }}">View Product</a>
                        @endif
                      </td>
                      <td class="action">
                      <a href="{{ route('web.remove_wish_list', ['product_id' => $item->id]) }}">
                          <span>
                            <i class="fa fa-trash-o"></i>
                          </span>
                        </a>
                      </td>
                    </tr> 
                  @endforeach
                </tbody>
              </table>
              <div class="cart_navigation">
                <a href="{{ route('web.index') }}" class="button continue-shopping" title="Continue shopping" ><span>Continue shopping</span></a>
                
                {{-- <button class="button btn-proceed-checkout" title="Proceed to Checkout" type="button" onclick="window.location='{{route('web.checkout')}}';" ><span>Proceed to Checkout</span></button> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @else
     <center>
        <div class="emptycrt">
          <img src="http://localhost/assam_products/public/web/images/no-product.jpg" alt="">
            <p style="margin: 10px 0 0">Wishlist is Empty</p>
        </div>
      </center>
  @endif
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