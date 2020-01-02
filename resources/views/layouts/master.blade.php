<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->

<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>Omega POS</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <link rel="shortcut icon" href="{{ asset('img/logo.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<!-- END HEAD -->

    @include('includes.styles')

</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-fixed page-md">
<div id="app">
    <div class="clearfix"></div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container row">
        {{-- <div class="wrapper"> --}}


    @include('includes.nav')
        <div class="clearfix"></div>

        <div class="col-4">

            @include('includes.sidebar')
        </div>
        {{-- <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <router-view></router-view>
                        <vue-progress-bar></vue-progress-bar>
                    </div>
                </div>
                <!-- ./wrapper -->
            </div> --}}

    <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper ">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content col-md-12" style="position:fixed;">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN PAGE BAR -->

                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->

                <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->
                <div class=" col-md-10">
                    <router-view></router-view>
                    <vue-progress-bar></vue-progress-bar>
                </div>
            </div>
            <!-- END CONTENT BODY -->
        </div>

        <!-- END QUICK SIDEBAR -->

        <!-- END CONTENT -->
        @include('includes.themepanel')
        @include('includes.footer')
        {{-- </div> --}}
    </div>
</div>
@include('includes.scripts')

</body>
</html>
