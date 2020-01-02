{{-- <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="./img/logo.png" alt="laraStart Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Pharmacy</span>
    </a>

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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @if (Auth::user()->type == 1)
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-tachometer-alt text-blue"></i>
                        <p>
                            {{ __('sidebar.dashboard') }}
                        </p>
                    </router-link>
                </li>
                @endif
                <li class="nav-item">
                    <router-link to="/pos" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-cash-register text-blue"></i>
                        <p>
                            {{ __('sidebar.pos') }}

                        </p>
                    </router-link>
                </li>
                @if (Auth::user()->type == 1)
                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-cog text-green"></i>
                        <p>
                            {{ __('sidebar.management') }}

                            <i style="color: rgb(54, 198, 211);" class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/users" class="nav-link">
                                <i style="color: rgb(54, 198, 211);" class="fas fa-users nav-icon text-teal"></i>
                                <p> {{ __('sidebar.users') }} </p>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-boxes text-green"></i>
                        <p>
                            {{ __('sidebar.products') }}

                            <i style="color: rgb(54, 198, 211);" class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/products" class="nav-link">
                                <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-box text-teal"></i>
                                <p>
                                    {{ __('sidebar.productslist') }}
                                </p>
                            </router-link>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/categories" class="nav-link">
                                <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-warehouse text-teal"></i>
                                <p>
                                    {{ __('sidebar.productscategories') }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/units" class="nav-link">
                                <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-warehouse text-teal"></i>
                                <p>
                                    {{ __('sidebar.units') }}
                                </p>
                            </router-link>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-file-invoice-dollar text-red"></i>
                        <p>
                            {{ __('sidebar.expenses') }}
                            <i style="color: rgb(54, 198, 211);" class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/expenses" class="nav-link">
                                <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-coins text-pink"></i>
                                <p>
                                    {{ __('sidebar.expenseslist') }}

                                </p>
                            </router-link>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/expensescategories" class="nav-link">
                                <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-warehouse text-pink"></i>
                                <p>
                                    {{ __('sidebar.expensescategories') }}

                                </p>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <router-link to="/sales" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-money-bill-alt text-green"></i>
                        <p>
                            {{ __('sidebar.allsales') }}

                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/saledetails" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-money-bill-alt text-green"></i>
                        <p>
                            {{ __('sidebar.salesdetails') }}

                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/missingitems" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-money-bill-alt text-green"></i>
                        <p>
                            {{ __('sidebar.missingitems') }}

                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/profile" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-user text-orange"></i>
                        <p>
                            {{ __('sidebar.profile') }}

                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/developer" class="nav-link">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-cogs text-orange"></i>
                        <p>
                            {{ __('sidebar.developer') }}

                        </p>
                    </router-link>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                        <i style="color: rgb(54, 198, 211);" class="nav-icon fas fa-power-off text-red"></i>
                        <p>
                            {{ __('sidebar.logout') }}

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
</aside> --}}
<!-- BEGIN SIDEBAR -->

<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper hide">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                    <span></span>
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>

            @if (Auth::user()->type == 1)
                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="icon-home"></i>
                        <span class="title">الرئيسية</span>
                    </router-link>
                </li>
            @endif



            @if (Auth::user()->type == 1 || Auth::user()->type == 0)
                <li class="nav-item">
                    <router-link to="/pos" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-cart-plus"></i>
                        <span class="title">نقطة البيع</span>
                    </router-link>
                </li>
            @endif


            @if (Auth::user()->type == 1)
                <li class="nav-item">
                    <router-link to="/users" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-users"></i>
                        <span class="title">المستخدمين</span>
                    </router-link>
                </li>
            @endif



            @if (Auth::user()->type == 1)
                <li class="nav-item">
                    <router-link to="/products" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-medkit"></i>
                        <span class="title">المنتجات</span>
                    </router-link>
                </li>
            @endif



            @if (Auth::user()->type == 1)
                <li class="nav-item">
                    <router-link to="/categories" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-database"></i>
                        <span class="title">اصناف المنتجات</span>
                    </router-link>
                </li>
            @endif

            @if (Auth::user()->type == 1)
                <li class="nav-item">
                    <router-link to="/company" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-truck"></i>
                        <span class="title">الشركات</span>
                    </router-link>
                </li>
            @endif



            @if (Auth::user()->type == 1)
                <li class="nav-item">
                    <router-link to="/units" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-balance-scale"></i>
                        <span class="title">وحدات القياس</span>
                    </router-link>
                </li>
            @endif


            <li class="nav-item">
                <router-link to="/expenses" class="nav-link nav-toggle">
                    <i style="color: rgb(54, 198, 211);" class="fa fa-minus-circle"></i>
                    <span class="title">المنصرفات</span>
                </router-link>
            </li>


            <li class="nav-item">
                <router-link to="/expensescategories" class="nav-link nav-toggle">
                    <i style="color: rgb(54, 198, 211);" class="fa fa-list-ul"></i>
                    <span class="title">اصناف المنصرفات</span>
                </router-link>
            </li>


            @if (Auth::user()->type == 1 || Auth::user()->type == 2)
                <li class="nav-item">
                    <router-link to="/sales" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-dollar"></i>
                        <span class="title">المبيعات</span>
                    </router-link>
                </li>
            @endif


            @if (Auth::user()->type == 1)
                <li class="nav-item">
                    <router-link to="/saledetails" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-th"></i>
                        <span class="title">تفاصيل المبيعات</span>
                    </router-link>
                </li>
            @endif


            @if (Auth::user()->type == 1 || Auth::user()->type == 0)
                <li class="nav-item">
                    <router-link to="/missingitems" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-remove"></i>
                        <span class="title">الأصناف الناقصة</span>
                    </router-link>
                </li>
            @endif


            @if (Auth::user()->type == 1)
                <li class="nav-item">
                    <router-link to="/developer" class="nav-link nav-toggle">
                        <i style="color: rgb(54, 198, 211);" class="fa fa-code"></i>
                        <span class="title">للمطورين</span>
                    </router-link>
                </li>
            @endif


            <li class="nav-item">
                <a class="nav-link nav-toggle" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
           document.getElementById('logout-form').submit();">
                    <i style="color: rgb(54, 198, 211);" class="fa fa-power-off"></i>
                    <span class="title">تسجيل خروج</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

            </li>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->

