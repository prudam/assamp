<!-- Footer -->
    <footer>
      {{-- <div class="footer-top">
        <div class="">
          <div class="row">
            <address>
              <p><i class="fa fa-mobile"></i><span>(+91)-7002037984 / 9706028611</span> </p>
              <p> <i class="fa fa-map-marker"></i>M/S Eagle Group, #28, Lane-02, Sanghati Path, Kailash Nagar, Beltola, Guwahati-781028, Assam </p>
              <p> <i class="fa fa-envelope"></i><span><a href="mailto:email@domain.com">eaglegroup.assam@gmail.com</a></span></p>
            </address>
          </div>
        </div>
      </div> --}}
      <div class="footer-inner">
        <div class="container" style="padding: 20px 0;">
          <div class="row">            
            <div class="col-sm-4 col-xs-12 col-md-3">
              <div class="footer-links">
                <h4>Useful links</h4>
                <ul class="links" style="text-transform: uppercase;">
                    <li><a href="{{route('web.extra.privacy')}}"> Privacy policy </a> </li>
                    <li><a href="{{route('web.extra.privacy')}}"> Terms of Use </a> </li>
                    <li><a href="{{route('web.extra.privacy')}}"> return policy </a> </li>
                    <li><a href="{{route('web.extra.privacy')}}"> Payment Security </a> </li>
                  {{-- @auth('users')
                    <li><a title="cart" href="{{route('web.view_cart')}}">cart</a> </li>
                    <li><a title="Wishlist" href="{{ route('web.wish_list') }}">Wishlist</a> </li>
                    <li><a href="{{ route('web.order_history') }}">My Orders</a> </li>
                  @else
                    <li><a title="cart" href="{{route('web.view_cart')}}">cart</a> </li>
                    <li><a title="Signin" href="{{route('web.login')}}">Signin</a> </li>
                    <li><a title="Signin" href="{{route('user.registration_page')}}">Signup</a> </li>
                  @endauth
                    <li><a href="{{route('web.extra.about')}}"> About Us </a> </li>
                    <li><a href="{{route('web.extra.privacy')}}"> Terms & Condition </a> </li> --}}
                </ul>
              </div>
            </div>
            <div class="col-sm-4 col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-sm-12 col-md-4">
              <div class="social">
                <h4>Follow Us</h4>
                <ul class="inline-mode">
                  <li class="social-network fb"><a title="Connect us on Facebook" target="_blank" href="https://www.facebook.com/Eagle-Group-1150406678338693/"><i class="fa fa-facebook"></i></a></li>
                  <li class="social-network instagram"><a title="Connect us on Instagram" target="_blank" href="https://www.instagram.com/eaglegroup.assam/"><i class="fa fa-instagram"></i></a></li>
                  <li class="social-network googleplus"><a title="Connect us on Pinterest" target="_blank" href="https://in.pinterest.com/eaglegroupassam/"><i class="fa fa-pinterest-p"></i></a></li></li>
                </ul>
              </div>
            </div>
            <div class="col-sm-4 col-xs-12 col-md-4">
              <div class="footer-links">
                <h4>GET IN TOUCH</h4>
                {!! $footer_data['footer']->footer_contact_info !!}
              </div>            
            </div>
        </div>
      </div>
      <div class="footer-bottom">
        <div class="container">
          <div class="row">
            <div class="col-sm-7 col-xs-12 coppyright">Copyright@2020 EAGLE GROUP. All Rights Reserved. </div>
            <div class="col-sm-5 col-xs-12 payment-accept">
              <ul>
                <li> <a href="#"><img src="{{asset('web/images/payment-1.png')}}" alt="Payment Card"></a> </li>
                <li> <a href="#"><img src="{{asset('web/images/payment-2.png')}}" alt="Payment Card"></a> </li>
                <li> <a href="#"><img src="{{asset('web/images/payment-3.png')}}" alt="Payment Card"></a> </li>
                <li> <a href="#"><img src="{{asset('web/images/payment-4.png')}}" alt="Payment Card"></a> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <!-- End Footer --> 

  <!-- jquery js --> 
  <script type="text/javascript" src="{{asset('web/js/jquery.min.js')}}"></script> 

  <!-- bootstrap js --> 
  <script type="text/javascript" src="{{asset('web/js/bootstrap.min.js')}}"></script> 

  <!-- owl.carousel.min js --> 
  <script type="text/javascript" src="{{asset('web/js/owl.carousel.min.js')}}"></script> 

  <!-- jtv-jtv-mobile-menu js --> 
  <script type="text/javascript" src="{{asset('web/js/jtv-mobile-menu.js')}}"></script> 

  <!-- countdown js --> 
  <script type="text/javascript" src="{{asset('web/js/countdown.js')}}"></script> 

  <!-- main js --> 
  <script type="text/javascript" src="{{asset('web/js/main.js')}}"></script> 

  <!-- rev-slider js --> 
  <script type="text/javascript" src="{{asset('web/js/rev-slider.js')}}"></script> 
  <script type="text/javascript" src="{{asset('web/js/cloud-zoom.js')}}"></script>
  <script type='text/javascript'>
  jQuery(document).ready(function() {
  jQuery('#jtv-rev_slider').show().revolution({
  dottedOverlay: 'none',
  delay: 5000,
  startwidth: 1140,
  startheight: 400,
  hideThumbs: 200,
  thumbWidth: 200,
  thumbHeight: 50,
  thumbAmount: 2,
  navigationType: 'thumb',
  navigationArrows: 'solo',
  navigationStyle: 'round',
  touchenabled: 'on',
  onHoverStop: 'on',
  swipe_velocity: 0.7,
  swipe_min_touches: 1,
  swipe_max_touches: 1,
  drag_block_vertical: false,
  spinner: 'spinner0',
  keyboardNavigation: 'off',
  navigationHAlign: 'center',
  navigationVAlign: 'bottom',
  navigationHOffset: 0,
  navigationVOffset: 20,
  soloArrowLeftHalign: 'left',
  soloArrowLeftValign: 'center',
  soloArrowLeftHOffset: 20,
  soloArrowLeftVOffset: 0,
  soloArrowRightHalign: 'right',
  soloArrowRightValign: 'center',
  soloArrowRightHOffset: 20,
  soloArrowRightVOffset: 0,
  shadow: 0,
  fullWidth: 'on',
  fullScreen: 'off',
  stopLoop: 'off',
  stopAfterLoops: -1,
  stopAtSlide: -1,
  shuffle: 'off',
  autoHeight: 'off',
  forceFullWidth: 'on',
  fullScreenAlignForce: 'off',
  minFullScreenHeight: 0,
  hideNavDelayOnMobile: 1500,
  hideThumbsOnMobile: 'off',
  hideBulletsOnMobile: 'off',
  hideArrowsOnMobile: 'off',
  hideThumbsUnderResolution: 0,
  hideSliderAtLimit: 0,
  hideCaptionAtLimit: 0,
  hideAllCaptionAtLilmit: 0,
  startWithSlide: 0,
  fullScreenOffsetContainer: ''
  });
  });
  </script> 
  <!-- Hot Deals Timer 1--> 
  <script type="text/javascript">
  var dthen1 = new Date("12/25/17 11:59:00 PM");
  start = "08/04/15 03:02:11 AM";
  start_date = Date.parse(start);
  var dnow1 = new Date(start_date);
  if (CountStepper > 0)
  ddiff = new Date((dnow1) - (dthen1));
  else
  ddiff = new Date((dthen1) - (dnow1));
  gsecs1 = Math.floor(ddiff.valueOf() / 1000);

  var iid1 = "countbox_1";
  CountBack_slider(gsecs1, "countbox_1", 1);
  </script> 
    <script>
$(document).ready(function(){
  $("#this-togg").click(function(){
    $(".search-box").toggleClass("disply-blk");    
    $(".mm-toggle1").toggleClass("closeit");
    $(".closeit").click(function(){
      $("#livesearch").css("display", "none");
    });
    
  });
});

// this is the id of the form
$("#search_form").submit(function(e) {

e.preventDefault(); // avoid to execute the actual submit of the form.

var key_srch = $("#search").val();
window.location.href = "{{url('product-search-submit/')}}/"+key_srch;
});
</script>
</body>

</html>
