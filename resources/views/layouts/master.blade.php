<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Lara Start</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('includes.styles')

</head>
<body class="hold-transition sidebar-mini">
<div id="app">
    <div class="wrapper">

        @include('includes.nav')

        @include('includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <!-- /.content-header -->
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <router-view></router-view>
                    <vue-progress-bar></vue-progress-bar>
                </div>
                <!-- /.content -->
            </div>
        </div>
        <!-- /.content-wrapper -->

        @include('includes.footer')

    </div>
</div>
<!-- ./wrapper -->

@include('includes.scripts')

</body>
</html>
