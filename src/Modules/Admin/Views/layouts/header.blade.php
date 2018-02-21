<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"><img src="{!! asset('public/assets/admin/img/logo.png') !!}" class="img-fluid mx-auto" alt="#"> RST</a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Dashboard</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Users</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto mr-4">
        {{--<li class="nav-item d-md-down-none">--}}
            {{--<a class="nav-link" href="#"><i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span></a>--}}
        {{--</li>--}}
        {{--<li class="nav-item d-md-down-none">--}}
            {{--<a class="nav-link" href="#"><i class="icon-list"></i></a>--}}
        {{--</li>--}}
        {{--<li class="nav-item d-md-down-none">--}}
            {{--<a class="nav-link" href="#"><i class="icon-location-pin"></i></a>--}}
        {{--</li>--}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{!! asset('public/assets/admin') !!}/img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Tài Khoản</strong>
                </div>
                <a class="dropdown-item" href="#"><i class="fa fa-bell-o"></i> Liên Hệ <span class="badge badge-info">42</span></a>
                <div class="dropdown-header text-center">
                    <strong>Cấu Hình</strong>
                </div>
                <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="#"><i class="fa fa-lock"></i> Logout</a>
            </div>
        </li>
    </ul>
</header>