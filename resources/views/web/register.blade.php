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
      <div class="account-login register-login">
        {{-- <div class="page-title">
          <h2>Create an Account</h2>
        </div> --}}
          <div class="registered-users"><strong>Create An Account</strong>
            <div class="content">
                @if(session()->has('msg'))
                    <p style="font-weight: bolder; color: blue;">{{ session()->get('msg') }}</p>
                @else
                    <p>If you don't have an account with us, please register in.</p>
                @endif              
              <form action="{{ route('user.registration') }}" autocomplete="off">
              <ul class="form-list">
                <li>
                    <div class="row">
                        <div class="col-sm-12">
                          <label for="name">Name <span class="required">*</span></label>
                          <br>
                          <input type="text" name="name" value="{{ old('name') }}" class="input-text required-entry" required>
                           @error('name')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="name">Type <span class="required">*</span></label>
                      <br>
                      <select class="input-select required-entry" name="user_role" id="user_role" required>
                          <option>Choose Customer Type</option>
                            @if(old('user_role') == 1)
                                <option value="1" selected>Customer</option>
                                <option value="2">Seller</option>
                            @elseif(old('user_role') == 2)
                                <option value="1">Customer</option>
                                <option value="2" selected>Seller</option>
                            @else
                                <option value="1">Customer</option>
                                <option value="2">Seller</option>
                            @endif
                      </select>
                       @error('user_role')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6" id="gst_div">
                      <label for="email">GST No (GST No. is must for Sellers) <span class="required">*</span></label>
                      <br>
                      <input type="text" class="input-text required-entry" value="{{ old('gst_no') }}" name="gst_no">
                      <span id="msg"></span>
                       @error('gst_no')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="email">Email Address <span class="required">*</span></label>
                      <br>
                      <input type="email" class="input-text required-entry" value="{{ old('email') }}" name="email" required>
                        @error('email')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                      <label for="email">Phone Number (Contact no. should be of 10 digits) <span class="required">*</span></label>
                      <br>
                      <input type="number" class="input-text required-entry" value="{{ old('contact_no') }}" name="contact_no"> 
                        @error('contact_no')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror                     
                    </div>
                  </div>
                </li>
                <li>
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="pass">Password <span class="required">*</span></label>
                      <br>
                      <input type="password" class="input-text required-entry validate-password" name="password" required>
                       @error('password')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror 
                    </div>
                    <div class="col-sm-6">
                      <label for="pass">Confirm Password <span class="required">*</span></label>
                      <br>
                      <input type="password" title="Confirm Password" name ="confirm_password" class="input-text required-entry validate-password">                      
                    </div>
                  </div>
                </li>
              </ul>
              <p class="required">* Required Fields</p>
              <div class="buttons-set">
                <button id="send2" name="send" type="submit" class="button login"><span>Register Account</span></button>
              </div>
                </form>
              <hr>
              <p>If you have an account with us, please log in.</p>
              <a class="button login " href="{{route('web.login')}}">LOGIN TO ACCOUNT</a> 
            </div>
          </div>
      </div>
 
    </div>
  </section>
  
   <!-- Footer -->
   @endsection  

   @section('script')
   <script type="text/javascript">
     $(document).ready(function(){

       var user_role = $('#user_role').val();

       if (user_role == 2) {
            $('#gst_div').show();
       } else{
            $('#gst_div').hide();
       }

      
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

         $('#user_role').change(function(){
           var user_role = $('#user_role').val();

           if(user_role == 1)
            $('#gst_div').hide();
           else
            $('#gst_div').show();
         });
     });
   </script>
 @endsection
