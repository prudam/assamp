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
    <div class="main container">
      <div class="col-main">
        <div class="shopping-cart-inner">
          <div class="page-content">
            <ul class="step">
              <li class="done-step new"><span><i class="fa fa-check"></i> Summary</span></li>
              <li class="done-step"><span><i class="fa fa-check"></i> Sign in</span></li>
              <li class="current-step done-step"><span>Checkout</span></li>
              <li><span>Order Corfirmation</span></li>
            </ul>
            @if(!empty($coupon) && (count($coupon) > 0))
            <div class="offer-counter box-account">
              <div class="page-title">
                <h2 class="text-center"style="padding: 0 0 10px">Offers</h2>
              </div>
              <div class="row">
                @foreach($coupon as $key => $item)
                  <div class="col-md-3 col-xs-6">
                    <div class="single-offer">
                      <h1>{{ $item->coupon_amount }}% Off</h1>
                      <h6 style="margin-bottom: 0;">Use Coupon Code </h6>
                      <h6 style="margin:2.5px 0 2.5px;text-decoration: none;">{{ $item->coupon_desc }}</h6>
                      <h4>{{ $item->coupon_code }}</h4>
                      {{-- <button type="button" onclick="copy_coupon({{ $item->id }})" class="cpybtn"><i class="fa fa-clone" aria-hidden="true"></i></button> --}}
                      
                    </div> 
                  </div>
                @endforeach
              </div>
            </div>
            @endif
            <div class="order-detail-content">
              <div class="row">
                <div class="col-md-8 box-account">
                  <div class="page-title">
                    <h2 class="text-center"style="padding: 0">Shipping Information</h2>
                  </div>

                  {{-- ADDRESS SELECTOR --}}
                  <div class="col2-set" id="select-address">
                    <h5 class="text-center" id="address_selection" style="font-weight: bold;">Select Address</h5>
                    @if(!empty($all_address) && (count($all_address) > 0))  
                        @foreach($all_address as $key => $item)              
                        <div class="col-1">
                          <div class="single-address flex">
                            <label class="radio-container">
                              <input type="radio" checked="checked" name="address" value="{{ $item->id }}">
                              <span class="checkmark"></span>
                            </label>
                            <div class="single-address-content">
                              <p>{{ $item->name }}</p>
                              <p>{{ $item->address }}</p>
                              <p>Phone: {{ $item->mobile_no }}</p>
                              <p>Email: {{ $item->email }}</p>
                              <p>{{ $item->city }}, {{ $item->state }}</p>
                              <p>Pincode: {{ $item->pin_code }}</p>
                              <a href="{{ route('web.delete_address', ['address_id' => $item->id]) }}" class="">Delete this address</a>
                            </div>
                            <div>
                            
                            </div>
                          </div>
                        </div>
                        @endforeach
                    @endif
                    <div class="manage_add" onclick="myFunction()"><h5 class="text-center">Add New Shipping Addresses</h5> </div>
                  </div>
                  {{-- END ADDRESS SELECTOR --}}

                  {{-- ADD NEW ADDRESS --}}
                  <div class="checkout-page" id="add-address" style="display: none;">
                    <h5 class="text-center">Add New Address</h5>   
                    <div class="box-border">
                    <form method="POST" action="{{ route('web.add_address') }}" autocomplete="off">
                      @csrf
                      <ul>
                        <li class="row">
                          <div class="col-sm-6">
                            <label for="first_name" class="required">Name</label>
                            <input type="text" class="input form-control" name="name" id="name">
                            <span id="name_msg" style="color: red;"></span>
                          </div>
                          <!--/ [col] -->
                          <div class="col-sm-6">
                            <label for="email_address" class="required">Email Address</label>
                            <input type="email" class="input form-control" name="email" id="email_address">
                            <span id="email_msg" style="color: red;"></span>
                          </div>
                          <!--/ [col] --> 
                        </li>
                        <!--/ .row -->
                        <li class="row">
                          <div class="col-xs-12">
                            <label for="address" class="required">Address</label>
                            <textarea class="input form-control form-area" name="address" id="address" rows="10"></textarea>
                            <span id="address_msg" style="color: red;"></span>
                          </div>
                          <!--/ [col] --> 
                          
                        </li>
                        <!-- / .row -->
                        <li class="row">
                          <div class="col-sm-6">
                            <label for="telephone">Phone Number</label>
                            <input type="number" name="contact_no" class="input form-control" id="telephone">
                            <span id="telephone_msg" style="color: red;"></span>
                          </div>
                          <!--/ [col] -->
                          <div class="col-sm-6">
                            <label for="postal_code" class="required">Pincode</label>
                            <input type="number" class="input form-control" name="pin_code" id="postal_code">
                            <span id="postal_code_msg" style="color: red;"></span>
                          </div>
                          <!--/ [col] --> 
                        </li>
                        <!--/ .row -->
                        
                        <li class="row">
                          <div class="col-sm-6">
                            <label for="city" class="required">City</label>
                            <input class="input form-control" type="text" name="city" id="city">
                            <span id="city_msg" style="color: red;"></span>
                          </div>
                          <!--/ [col] -->
                          
                          <div class="col-sm-6">
                            <label class="required">State/Province</label>
                            <input type="text" class="input form-control" name="state" id="state">
                            <span id="state_msg" style="color: red;"></span>
                          </div>
                          <!--/ [col] --> 
                        </li>
                        <!--/ .row -->
                        <li>
                          <button onclick="myFunction()" type="button" class="button button1">Cancel</button>
                          <button type="submit" class="button" id="address_btn">Add</button>
                        </li>
                      </ul>
                      </form>
                    </div>
                  </div>

                  {{-- ADD NEW ADDRESS --}}
                </div>
                <div class="col-md-4 box-account">
                  <div class="page-title">
                    <h2 class="text-center"style="padding: 0;padding-bottom: 10px">Payment Information</h2>
                  </div>

                  <div class="single-address">
                    <div class="paymttotal">
                      <h4 style="text-align: left;">Total Amount  </h4><h4 style="text-align: right;" id="total">{{ $total }}</h4>
                    </div>
                    <div id="shipping_charge" class="paymttotal">
                        <h4 style="text-align: left; font-size: 15px;border-bottom: 0">CoD Commission  </h4><h4 style="text-align: right; font-size: 15px;border-bottom: 0">{{ $shipping_amount }}</h4>
                    </div>
                    <form method="POST" action="{{ route('web.place_order') }}" autocomplete="off" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                        <div>
                          <input type="hidden" name="coupon_status_1" id="coupon_status_1"/>
                          <input type="hidden" name="address_id" id="address_id"/>
                          <div class="coupandiv">
                            <label>Coupon </label> <a id="coupon_remove" style="float: right; background: #e82424;display: block;COLOR: #FFF;PADDING: 0 5px; cursor: pointer;">Remove Coupon</a><br>
                            <input type="text" name="coupon" id="coupon" class="input form-control" placeholder="Enter Coupon" />
                            <b id="coupon_btn">Check</b>
                            <p id="coupon_status" style="color: green"></p>
                            
                          </div>
                        </div>
                        <div class="paymtmthd">
                          <label>Payment Methord *</label>
                          <label class="radio-container">
                            <input type="radio" name="payment_type" value="1" required checked class="payment_type_radio">
                            <span class="checkmark"></span>
                            Cash On Delivery
                            <div id="doc" style="font-size: 12px;padding-top: 5px;">
                                @if(session()->has('message'))
                                    <span style="color: red; font-weight: bold;">{{ session()->get('message') }}</span>
                                @endif<br>
                              (Upload both side of PAN, Voter ID, Any valid doc.JPG Only Image File. Please tap CTRL for multiple select)
                              <input type="file" name="doc[]" class="input form-control" style="margin-top: 8px;width: 89%;" accept="image/jpeg,image/jpg" multiple />
                              @error('doc')
                                <span style="font-weight: bold; color: red;">{{ $message }}</span>
                              @enderror
                              or
                              Facebook Profile Link
                              <input type="text" name="facebook_link" class="input form-control" style="margin-top: 8px;width: 89%;"/>
                              @error('facebook_link')
                                  <span style="font-weight: bold; color: red;">{{ $message }}</span>
                              @enderror
                            </div>
                          </label>
                          <label class="radio-container">
                            <input type="radio" name="payment_type" value="2" required class="payment_type_radio">
                            <span class="checkmark"></span>
                            Pay Online
                          </label> 
                        </div>
                        <button class="button btn-proceed-checkout" type="submit" id="btn_pay">Proceed</button>
                    </form>
                  </div>
                </div>  
                <div class="col-md-12 cart_navigation">
                  <a class="button continue-shopping" href="{{route('web.index')}}" type="button"><span style="font-size: 18px;font-weight: 300;">Continue shopping</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    @endsection
  @section('script')
  
  {{-- Select&Add Address Toggle --}}
  <script type="text/javascript">
    function myFunction() {
      var x = document.getElementById("add-address");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
      var y = document.getElementById("select-address");
      if (y.style.display === "none") {
        y.style.display = "block";
      } else {
        y.style.display = "none";
      }
    }
    function myFunction1() {
      var x = document.getElementById("add-address");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
      var y = document.getElementById("select-address");
      if (y.style.display === "none") {
        y.style.display = "block";
      } else {
        y.style.display = "none";
      }
    }

$(document).ready(function(){
  $('#coupon_remove').hide();
    old_total_amount = $('#total').text();
    address_id = $("input[name='address']:checked").val();
    if(typeof address_id === 'undefined') {
        $('#address_selection').text('Please! Add an address');
        $("#address_selection").css("color", "red");
    } else if(address_id === null){
        $('#address_selection').text('Please! Add an address');
        $("#address_selection").css("color", "red");
    } else
        $('#address_id').val(address_id);
    coupon_s = 0;
    $('#coupon_btn').click(function(){

        var coupon = $('#coupon').val();
        var total_amount = $('#total').text();

        localStorage.setItem("total_amount", total_amount);

        $('#coupon_remove').show();

        if (coupon != "") {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            $.ajax({
                method: "POST",
                url   : "{{ route('web.check_coupon') }}",
                data  : {
                    'coupon_code': coupon,
                    'total_amount': total_amount
                },
                success: function(response) {
                    if (isNaN(response)) {
                        $('#coupon_status').text(response);
                        $('#total').text(old_total_amount);
                    } else {
                        if (coupon_s == 0) {
                            total_1 = total_amount - response;
                            $('#total').text(total_1);
                            $('#coupon_status').text('Coupon Applied');
                            $('#coupon_status_1').val(1);
                            coupon_s = 1;
                        }
                    }
                }
            }); 
        }
    });

    $('#coupon_remove').click(function(){
      location.reload();
      // $('#total').text(localStorage.getItem("total_amount"));
      // localStorage.clear();
      // coupon_s = 0;
      // $('#coupon').val("");
      // $('#coupon_status').text("");
      // $('#coupon_remove').hide();
    });

    $('#btn_pay').click(function(){
        address_id = $("input[name='address']:checked").val();
        $('#address_id').val(address_id);
    });

    $(".payment_type_radio").click(function(){
        var radioValue = $("input[name='payment_type']:checked").val();
        if(radioValue == 2){
            $('#shipping_charge').hide();
            $('#doc').hide();
        } else {
            $('#shipping_charge').show();
            $('#doc').show();
        }
    });

    $('#address_btn').click(function(){
        var name = $('#name').val();
        var email = $('#email_address').val();
        var address = $('#address').val();
        var telephone = $('#telephone').val();
        var postal_code = $('#postal_code').val();
        var city = $('#city').val();
        var state = $('#state').val();

        if (name == "") {
            $('#name_msg').text('Name can\'t be empty');
            return false;
        } else
            $('#name_msg').text('');

        if (email == "") {
            $('#email_msg').text('Email can\'t be empty');
            return false;
        } else{
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            if (email.match(mailformat))
                $('#email_msg').text('');
            else {

                $('#email_msg').text('Invalid email');
                return false;
            }
        }

        if (address == "") {
            $('#address_msg').text('Address can\'t be empty');
            return false;
        } else
            $('#address_msg').text('');

        if (telephone == "") {
            $('#telephone_msg').text('Telephone can\'t be empty');
            return false;
        } else {
            if (telephone.length < 10){
                $('#telephone_msg').text('Contact no. should be of 10 digits');
                return false;
            }
            else if (telephone.length > 10){
                $('#telephone_msg').text('Contact no. should be of 10 digits');
                $('#telephone').val("");
                return false;
            } else
                $('#telephone_msg').text('');
        }

        if (postal_code == "") {
            $('#postal_code_msg').text('PIN Code can\'t be empty');
            return false;
        } else {
            if (postal_code.length < 6){
                $('#postal_code_msg').text('Pin code should be of 6 digits');
                return false;
            } 
            else if (postal_code.length > 6){
                $('#postal_code').val("");
                $('#postal_code_msg').text('Pin code should be of 6 digits');
                return false;
            } else
                $('#postal_code_msg').text('');
        }

        if (city == "") {
            $('#city_msg').text('City can\'t be empty');
            return false;
        } else
            $('#city_msg').text('');

        if (state == "") {
            $('#state_msg').text('State can\'t be empty');
            return false;
        } else
            $('#state_msg').text('');
    });

    $('#telephone').keyup(function(e){
        var telephone = $('#telephone').val();

        if (telephone.length < 10) 
            $('#telephone_msg').text('Contact no. should be of 10 digits');
        else{
            $('#telephone_msg').text('');
            event.preventDefault();
            return false;
        }
    });

    $('#postal_code').keyup(function(e){
        var postal_code = $('#postal_code').val();

        if (postal_code.length < 6) 
            $('#postal_code_msg').text('Pin code should be of 6 digits');
        else{
            $('#postal_code_msg').text('');
            event.preventDefault();
            return false;
        }
    });
});
  </script>
  {{-- Select&Add Address Toggle --}}
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

  <!-- Footer -->
   @endsection

