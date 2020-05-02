@include('web.include.header')
       
@yield('content')
    
    <!-- Default Statcounter code for bussiness website
http://www.assamproducts.com -->
<script type="text/javascript">
var sc_project=11348749; 
var sc_invisible=0; 
var sc_security="00159592"; 
var scJsHost = "https://";
document.write("<sc"+"ript type='text/javascript' src='" +
scJsHost+
"statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript><div class="statcounter"><a title="real time web
analytics" href="https://statcounter.com/"
target="_blank"></a></div></noscript>
<!-- End of Statcounter Code -->
<!--<a href="https://statcounter.com/p11348749/?guest=1">View My-->
<!--Stats</a>-->

@include('web.include.footer')
@yield('script')
  