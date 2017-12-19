<div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
  <ul class="list-group panel">
    <li class="list-group-item"><b>SIDE PANEL</b></li>
    <li class="list-group-item {{LP_lib::setActive(2,'dashboard')}}"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard </a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'user')}}"><a href="{{route('admin.user.index')}}"><i class="fa fa-user"></i>User Management</a></li>


  </ul>
</div>
