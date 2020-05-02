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
              @if (isset($sub_category_record->sub_cate_name))                  
                <li> <strong>{{ $sub_category_record->sub_cate_name }}</strong> </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Breadcrumbs End --> 
    
    <!-- Main Container -->
    <section class="main-container col2-left-layout">
      <div class="container">
        <div class="row">
          <div class="col-sm-9 col-sm-push-3">
            <article class="col-main" style="width: 100%;">              
              <div class="toolbar toolbar-top">
                <div class="row">
                  <div class="col-md-7 col-sm-5">
                    <h2 class="page-heading"> 
                      @if (isset($sub_category_record->sub_cate_name))
                        <span class="page-heading-title">{{ $sub_category_record->sub_cate_name }}</span> 
                      @endif
                    </h2>
                  </div>
                  <div class="col-sm-2 text-right sort-by">
                    {{-- <label class="control-label" for="input-sort">Sort By:</label> --}}
                  </div>
                  <div class="col-md-3 col-sm-2 text-right">
                    {{-- <select id="input-sort" class="form-control col-sm-3">
                      <option selected disabled>Default</option>
                      <option onclick="window.location='{{route('web.product_list', ['slug' => $sub_category_record->slug, 'sub_category_id' => $sub_category_record->id, 'sorted_by' => 1])}}'">Newest</option>
                      <option>Prich)</option>
                      <option>Priow)</option>
                    </select> --}}
                  </div>
                </div>
              </div>
                <div id="product_container">
                    @include('web.product.ajax.presult')
                </div>
            </article>
            <!--  ///*///======    End article  ========= //*/// --> 
          </div>
          <div class="sidebar col-sm-3 col-xs-12 col-sm-pull-9">
            <aside class="sidebar">
              <div class="block block-layered-nav">
                <div class="block-title">Shop By Catagories</div>
                <div class="block-content" id="sidebar">
                  <p class="block-subtitle">Shopping Options</p>                  
                  <div class="list-group">
                    @if(!empty($top_sub_category) && (count($top_sub_category) > 0))
                        @php
                        $i = 1;
                        @endphp
                        @foreach($top_sub_category as $key => $item)
                            @if($item['id'] == 4)

                            <a href="#menu{{ $i }}" class="list-group-item ji" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false">
                                 <i class="fa fa-angle-right"></i> 
                                <span class="hidden-sm-down">{{ $item['top_cate_name'] }}</span> 
                              </a>
                              @if(!empty($item['sub_category']) && (count($item['sub_category']) > 0))
                              <div class="collapse sub-cat" id="menu{{ $i }}">
                                @foreach($item['sub_category'] as $key_1 => $item_1)
                                  <a href="{{route('web.bell_brass_metal_product_list', ['slug' => $item_1->slug, 'sub_category_id' => $item_1->id])}}" class="list-group-item" data-parent="#menu{{ $i }}">{{ $item_1->sub_cate_name }}</a>
                                @endforeach
                              </div>
                              @endif
                            @else
                      <a href="#menu{{ $i }}" class="list-group-item ji" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false">
                          <i class="fa fa-angle-right"></i> 
                          <span class="hidden-sm-down">{{ $item['top_cate_name'] }}</span> 
                      </a>
                      @if(!empty($item['sub_category']) && (count($item['sub_category']) > 0))
                      <div class="collapse sub-cat" id="menu{{ $i }}">
                        @foreach($item['sub_category'] as $key_1 => $item_1)
                          <a href="{{route('web.product_list', ['slug' => $item_1->slug, 'sub_category_id' => $item_1->id, 'sorted_by' => 1])}}" class="list-group-item" data-parent="#menu{{ $i }}">{{ $item_1->sub_cate_name }}</a>
                        @endforeach
                      </div>
                      @endif

                      @endif
                      @php
                      $i++;
                      @endphp
                        @endforeach
                    @endif
                  </div>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </section>
    <!-- Main Container End --> 
    

  @endsection
  <!-- End Footer --> 
@section('script')
<script>
$(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        }else{
            getData(page);
        }
    }
});

$(document).ready(function(){
    
    $(document).on('click', '.pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var myurl = $(this).attr('href');
        var page=$(this).attr('href').split('page=')[1];
        getData(page);
    });

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

function getData(page){
    
    $.ajax({
        url: '?page=' + page,
        type: "get",
        datatype: "html",
        // beforeSend: function()
        // {
        //     you can show your loader 
        // }
    })
    .done(function(data){
        $("#product_container").empty().html(data);
        location.hash = page;
    })
    .fail(function(jqXHR, ajaxOptions, thrownError){
        alert('No response from server');
    });
}
</script>
@endsection
