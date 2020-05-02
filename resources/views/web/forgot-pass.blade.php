  @extends('web.templet.master')

  @include('web.include.seo')

  @section('seo')
    <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript">
  <meta name="author" content="John Doe">
  @endsection

  @section('content')
    <!-- end nav --> 
  
  <section class="main-container col1-layout product-login">
    <div class="main container">
      <div class="account-login register-login">
        <fieldset class="col2-set">
          <div class="new-users"><strong>Forgot password</strong>
            <div class="content">
                @if(session()->has('msg'))
                    <span style="font-weight: bold; color: red;">{{ session()->get('msg') }}</span>
                @endif
            <form method="POST" action="{{ route('web.verfication_code') }}" autocomplete="off">
                @csrf
              <ul class="form-list">
                <li>
                  <label for="email">Enter Email or Mobile No. <span class="required">*</span></label>
                  <br>
                  <input type="text" title="Email Address" class="input-text required-entry" id="email" value="" name="username">
                </li>
              </ul>
              @error('username')
                <span style="color: red; font-weight: bold;">{{ $message }}</span>
              @enderror
              <div class="buttons-set">
                <button id="send2" name="send" type="submit" class="button login"><span>Submit</span></button>
              </div>
          </form>
              <hr>
              <p>If you don't have an account with us, please register in.</p>
              <a class="button login " href="{{route('web.login')}}">CREATE AN ACCOUNT</a> 
            </div>
          </div>
        </fieldset>
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