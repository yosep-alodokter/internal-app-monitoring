<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ app('file.helper')->getFileUrl('alodokter_logo.ico', 'main_image') }}">
        @include('layouts.skote.head-css')
  </head>

    @yield('body')
    
    @yield('content')

    @include('layouts.skote.vendor-scripts')
    </body>
</html>