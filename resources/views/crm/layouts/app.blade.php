<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        {{-- Es necesario para que los comandos funcionen correctamente --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Rivera & Asociados</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->

        <link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{ URL::asset('vendors/nprogress/nprogress.css')}}" rel="stylesheet">
        <!-- bootstrap-wysiwyg -->
        <link href="{{ URL::asset('vendors/google-code-prettify/bin/prettify.min.css')}}" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="{{ URL::asset('/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('/build/css/custom.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('/css/fullcalendar.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('/css/jquery.dataTables.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('/css/jquery.maxlength.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('/css/sweetalert.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('/css/crm.css')}}" rel="stylesheet">
        @yield('stylesheets')
        <script type="text/javascript" src="{{  URL::asset('/vendors/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{  URL::asset('/js/moment.min.js') }}"></script>
        
    </head>

    @yield('body')
</html>