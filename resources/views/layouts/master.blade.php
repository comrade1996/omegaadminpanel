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
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt text-blue"></i>
                  <p>
                    Dashboard
                  </p>
                </router-link>
              </li>
          <li class="nav-item has-treeview  ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog text-green"></i>
              <p>
                Managment
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i class="fas fa-users nav-icon text-teal"></i>
                  <p>Users</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview  ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-boxes text-green"></i>
              <p>
                Products
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/products" class="nav-link">
                  <i class="nav-icon fas fa-box text-teal"></i>
                  <p>
                    Products List
                  </p>
                </router-link>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/categories" class="nav-link">
                  <i class="nav-icon fas fa-warehouse text-teal"></i>
                  <p>
                    Products Categories
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="nav-icon fas fa-user text-orange"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-power-off text-red"></i>
              <p>
              {{ __('Logout') }}
              </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

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
</div>
<!-- ./wrapper -->

@include('includes.scripts')

</body>
</html>
