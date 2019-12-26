<!-- Main Sidebar Container -->
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
                        <i class="nav-icon fas fa-tachometer-alt text-blue"></i>
                        <p>
                            {{ __('sidebar.dashboard') }}
                        </p>
                    </router-link>
                </li>
                @endif
                <li class="nav-item">
                    <router-link to="/pos" class="nav-link">
                        <i class="nav-icon fas fa-cash-register text-blue"></i>
                        <p>
                            {{ __('sidebar.pos') }}

                        </p>
                    </router-link>
                </li>
                @if (Auth::user()->type == 1)
                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog text-green"></i>
                        <p>
                            {{ __('sidebar.management') }}

                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/users" class="nav-link">
                                <i class="fas fa-users nav-icon text-teal"></i>
                                <p> {{ __('sidebar.users') }} </p>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-boxes text-green"></i>
                        <p>
                            {{ __('sidebar.products') }}

                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/products" class="nav-link">
                                <i class="nav-icon fas fa-box text-teal"></i>
                                <p>
                                    {{ __('sidebar.productslist') }}
                                </p>
                            </router-link>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/categories" class="nav-link">
                                <i class="nav-icon fas fa-warehouse text-teal"></i>
                                <p>
                                    {{ __('sidebar.productscategories') }}
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/units" class="nav-link">
                                <i class="nav-icon fas fa-warehouse text-teal"></i>
                                <p>
                                    {{ __('sidebar.units') }}
                                </p>
                            </router-link>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview  ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice-dollar text-red"></i>
                        <p>
                            {{ __('sidebar.expenses') }}
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/expenses" class="nav-link">
                                <i class="nav-icon fas fa-coins text-pink"></i>
                                <p>
                                    {{ __('sidebar.expenseslist') }}

                                </p>
                            </router-link>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/expensescategories" class="nav-link">
                                <i class="nav-icon fas fa-warehouse text-pink"></i>
                                <p>
                                    {{ __('sidebar.expensescategories') }}

                                </p>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <router-link to="/sales" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-alt text-green"></i>
                        <p>
                            {{ __('sidebar.allsales') }}

                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/saledetails" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-alt text-green"></i>
                        <p>
                            {{ __('sidebar.salesdetails') }}

                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/missingitems" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-alt text-green"></i>
                        <p>
                            {{ __('sidebar.missingitems') }}

                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/profile" class="nav-link">
                        <i class="nav-icon fas fa-user text-orange"></i>
                        <p>
                            {{ __('sidebar.profile') }}

                        </p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/developer" class="nav-link">
                        <i class="nav-icon fas fa-cogs text-orange"></i>
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
                        <i class="nav-icon fas fa-power-off text-red"></i>
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
</aside>
