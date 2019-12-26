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
<button onclick="{{changeLang()}}">lang</button>
    <!-- SEARCH FORM -->
    {{-- <div class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search"
                   aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" @click="searchit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div> --}}
    <div id="time" style="margin-left:5%"></div>
</nav>

<script type="text/javascript">
  function showTime() {
    var date = new Date(),
        utc = new Date(Date.UTC(
          date.getFullYear(),
          date.getMonth(),
          date.getDate(),
          date.getHours(),
          date.getMinutes(),
          date.getSeconds()
        ));

    document.getElementById('time').innerHTML = utc.toLocaleTimeString();
  }

  setInterval(showTime, 1000);
</script>
<!-- /.navbar -->
