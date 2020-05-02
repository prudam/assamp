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
          <div class="new-users"><strong>Set New Password</strong>
            <div class="content">
                @if(session()->has('msg'))
                    <span style="font-weight: bold; color: green;">{{ session()->get('msg') }}</span>
                @elseif(session()->has('error'))
                  <span style="font-weight: bold; color: red;">{{ session()->get('error') }}</span>
                @else
                  <span style="font-weight: bold; color: green;">A verification code is sent to your mobile no./e-mail ID. Please enter the code to set new password.</span>
                @endif
            <form action="{{ route('web.set_password', ['user_id' => $user_id]) }}" autocomplete="off">
                @csrf
              <ul class="form-list">
                <li>
                  <label for="email">Verification Code<span class="required">*</span></label>
                  <br>
                  <input type="text" title="Email Address" class="input-text required-entry" value="{{ old('verification_code') }}" name="verification_code">
                  @error('verification_code')
                    <span style="font-weight: bold; color: red;" id="verification_code_msg">{{ $message }}</span>
                  @enderror
                </li>
                <li>
                  <label for="email">New Password<span class="required">*</span></label>
                  <br>
                  <input type="password" class="input-text required-entry" name="password">
                  @error('password')
                    <span style="font-weight: bold; color: red;" id="password_msg">{{ $message }}</span>
                  @enderror
                </li>
                <li>
                  <label for="email">Confirm Password<span class="required">*</span></label>
                  <br>
                  <input type="text" class="input-text required-entry" name="confirm_password" id="confirm_password">
                  @error('confirm_password')
                    <span style="font-weight: bold; color: red;">{{ $message }}</span>
                  @enderror
                </li>
              </ul>
              <p class="required">* Required Fields</p>
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