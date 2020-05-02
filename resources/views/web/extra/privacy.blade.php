@extends('web.templet.master')

  @include('web.include.seo')

  @section('seo')
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="John Doe">
  @endsection
  <!-- end nav -->
  @section('content')
    <div class="main-container col2-right-layout">
      <div class="main container">
        <div class="row">
          <div class="col-sm-12">
            <div class="col-main" style="width: 100%;">
              <div class="blog-wrapper" id="main">
                <div class="site-content" id="primary">
                  <div role="main" id="content">
                    <article class="blog_entry">
                      <header class="blog_entry-header">
                        <div class="blog_entry-header-inner">
                          <h2 class="blog_entry-title">POLICIES</h2><hr style="margin: 5px 0;">
                        </div>
                        <!--blog_entry-header-inner--> 
                      </header>
                      <!--blog_entry-header-->
                      <div class="entry-content clearfix">
                        {!! $privacy->privacy !!}
                      </div>
                    </article>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
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