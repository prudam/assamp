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
          <div class="new-users"><strong>Login</strong>
            <div class="content">
                @if (session()->has('login_error'))
                    <p style="font-weight: bolder; color: blue;">{{ session()->get('login_error') }}</p>
                @else
                    <p>If you have an account with us, please log in.</p>
                @endif
              <form action="{{ url('login') }}" autocomplete="off" method="POST">
                @csrf
              <ul class="form-list">
                <li>
                  <label for="email">Email or Mobile No <span class="required">*</span></label>
                  <br>
                  <input type="text" title="Mobile No" class="input-text required-entry" id="email" value="{{ old('username') }}" name="username">
                </li>
                <li>
                  <label for="pass">Password <span class="required">*</span></label>
                  <br>
                  <input type="password" title="Password" id="pass" class="input-text required-entry validate-password" name="password">
                </li>
              </ul>
              <p class="required">* Required Fields</p>
              <div class="buttons-set">
                <button id="send2" name="send" type="submit" class="button login"><span>Login</span></button>
                <a class="forgot-word" href="{{ route('web.forgot_pass_form') }}">Forgot Your Password?</a> 
              </div>
              </form>
              <hr>
              <p>If you don't have an account with us, please register in.</p>
              <a class="button login " href="{{route('user.registration_page')}}">CREATE AN ACCOUNT</a> 
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