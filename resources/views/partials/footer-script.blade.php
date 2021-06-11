<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/modernizr.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ URL::asset('assets/js/waves.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.scrollTo.min.js') }}"></script>

 @yield('script')

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>

<!-- App js -->
<script src="{{ URL::asset('assets/js/app.js') }}"></script>

@if(Session::has('success') || Session::has('error'))
    
        @if(Session::has('success'))
            <script>
                $(function(){
                    var message = "{{ Session::get('success') }}";
                    show_notify("success",message);  
                })
            </script>
        @endif
    
        @if(Session::has('error'))
            <script>
                $(function(){
                    var message = "{{ Session::get('error') }}";
                    show_notify("error",message);  
                })
            </script>
        @endif
    
    @endif
 
@yield('script-bottom')
