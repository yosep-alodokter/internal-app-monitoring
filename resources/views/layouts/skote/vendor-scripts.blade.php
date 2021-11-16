<!-- JAVASCRIPT -->
<script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js')}}"></script>

<script src="{{ URL::asset('assets/js/dependency/helper/serializeObject.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/dependency/helper/notificationHelper.js') }}"></script>
<script src="{{ URL::asset('js/dashboard/notifications.js') }}"></script>

@yield('script')

<!-- App js -->
<script src="{{ URL::asset('assets/js/app.min.js')}}"></script>
<script src="{{ URL::asset('js/mains.js') }}"></script>

@yield('script-bottom')