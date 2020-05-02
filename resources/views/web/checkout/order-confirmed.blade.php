  @extends('web.templet.master')

  @include('web.include.seo')

  @section('seo')
    <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript">
  <meta name="author" content="John Doe">
  
  @endsection

  @section('content')
  <!-- end nav --> 
  
    <!-- main-container -->
    <section class="content-wrapper">
      <div class="container">
        <div class="std">
          <div class="page-not-found">
            <h2>Order COnfirmed</h2>
            <h3><img src="{{asset('web/images/signal.png')}}">Thank You. Your order has been placed. A confirmation SMS and mail will be send to you..</h3>
            <div><a href="{{ route('web.index') }}" type="button" class="btn-home"><span>Continue Shopping</span></a></div>
          </div>
        </div>
      </div>
    </section>    
    <!--End main-container -->    

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