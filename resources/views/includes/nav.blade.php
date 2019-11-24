<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>

    </ul>

    <!-- SEARCH FORM -->
    <div class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search"
                   aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" @click="searchit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>

</nav>
<!-- /.navbar -->
