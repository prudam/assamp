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
            <div class="col-main">
              <div class="blog-wrapper" id="main">
                <div class="site-content" id="primary">
                  <div role="main" id="content">
                    <article class="blog_entry">
                      <header class="blog_entry-header">
                        <div class="blog_entry-header-inner">
                          <h2 class="blog_entry-title">About Us</h2><hr style="margin: 5px 0;">
                        </div>
                        <!--blog_entry-header-inner--> 
                      </header>
                      <!--blog_entry-header-->
                      <div class="entry-content clearfix">
                        <h3><em><strong><span style="color: #000000;"><u>About Eagle Group </u></span></strong></em></h3>
                        <p><span style="color: #000000;">Eagle Group deals in the Assamese traditional materials those have good reputation globally. 3 prime materials are chosen initially to offer an identity different from the existing. The products are- Mekhela Chadar, Bell & Brass Metal Products and Tea.</span></p>

                        <p><span style="color: #000000;">EAGLE TRADITION is a brand of Eagle Group created for marketing of its products at lower cost than any other product of its category available in the market. Depiction of various categories of products is briefed as under:</span></p>
                        <h3>MEKHELA CHADAR:</h3>
                        <p><span style="color: #000000;">MEKHELA CHADAR is an advanced version of Saree used by the women in North East India. It is divided into 2 main pieces to be draped around the body. Bottom portion, draped from the waist downwards is known as MEKHELA. Top portion, known as CHADAR, is a long cloth that has one end tucked into the upper portion of the MEKHELA and the rest draped over and around the rest of the body. A fitted blouse is also worn in normal manner.</span></p>

                        <p><span style="color: #000000;">Both of pure quality Assam Silk and Cotton material products of trendy designs are introduced under the brand EAGLE TRADITION. Saree is also available in both the materials.</span></p>
                        
                        <h3>BELL & BRASS METAL PRODUCTS:</h3>
                        <p><span style="color: #000000;">BELL METAL is a hard alloy used in the production of kitchen and other domestic materials such as plate/ dish, bowl, spoon, saunf serving tray and many more. It is a form of bronze, usually in approximately a 4:1 ratio of copper to tin (e.g., 78% copper, 22% tin by mass). BELL METAL is very beautiful and expensive metal used in manufacturing of the objects of domestic exercise in the state of Assam and few other places. People of ancient India had been using utensils made of bell, brass and copper metals due to their health friendly advantages- stomach problem, life taking diseases like cancer etc. caused by aluminium, plastic and few other such materials can be evaded by using bell metal. BELL METAL is the costliest, next to bronze.</span></p>
                        
                        <p><span style="color: #000000;">A Gift and Dinner Set is introduced under the brand EAGLE TRADITION with attractive packaging for personal use and occasions like Annaprasanna/ Wedding ceremony etc. as well. It has different category of products based on the cost.</span></p>
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