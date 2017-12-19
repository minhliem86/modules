<div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
  <ul class="list-group panel">
    <li class="list-group-item"><b>SIDE PANEL</b></li>
    <li class="list-group-item {{LP_lib::setActive(2,'dashboard')}}"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Dashboard </a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'country')}}"><a href="{{route('admin.country.index')}}"><i class="fa fa-institution"></i>Countries </a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'course')}}"><a href="{{route('admin.course.index')}}"><i class="fa fa-steam-square "></i>Courses </a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'testimonial')}}"><a href="{{route('admin.testimonial.index')}}"><i class="fa fa-volume-off"></i>Testimonials </a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'promotion')}}"><a href="{{route('admin.promotion.index')}}"><i class="fa fa-asterisk"></i>Promotions</a></li>
    <li class="list-group-item {{LP_lib::setActive(2,'contest')}}"><a href="{{route('admin.contest.index')}}"><i class="fa fa-comment"></i>Contest</a></li>
  </ul>
</div>
