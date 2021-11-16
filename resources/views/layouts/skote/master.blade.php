@if (is_null(Auth::user()))
    <script>window.location = "/login";</script>
    <?php exit; ?>
@endif

@php
    $group_site_id = null;    
    $isSuperAdmin = Auth::user()->hasRole(['superadmin']);

    if (!$isSuperAdmin) $group_site_id = Auth::user()->group_id;
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="route-fetch-groupsite-list" content="{{ route('api.v1.user.groupsite.dropdown.list') }}">
    <meta name="group-site-id" content="{{ $group_site_id }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ app('file.helper')->getFileUrl('alodokter_logo.ico', 'main_image') }}">
    @include('layouts.skote.head-css')
</head>

@section('body')
    <body data-sidebar="dark">
@show
    <!-- Begin page -->
    {{-- <div class="section-loader">
        <div class="thumb-loader part-loader"></div>
    </div> --}}
    <div id="layout-wrapper">
        @include('layouts.skote.topbar')
        @include('layouts.skote.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.skote.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    @include('layouts.skote.vendor-scripts')
</body>

</html>
