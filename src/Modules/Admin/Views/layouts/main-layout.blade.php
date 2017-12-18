<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>@yield('title', 'DASHBOARD')</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="shortcut icon" href="favicon_16.ico"/>
    <link rel="bookmark" href="favicon_16.ico"/>
    <!-- site css -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/bootflat-admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/css/site.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/css/customize.min.css">
    @yield('css')
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/scroll/jquery.mCustomScrollbar.min.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
    <!-- <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'> -->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/bootflat-admin/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/site.min.js"></script>
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/scroll/jquery.mCustomScrollbar.min.js"></script>
    <!-- CHART JS -->
    <script src="{{asset('/public/assets/admin')}}/dist/js/Chart.js"></script>
    <script>
      $(document).ready(function(){
        $('.panel-body').mCustomScrollbar({
            // scrollbarPosition: 'outside',
            autoHideScrollbar: true,
            scrollInertia: 250
        })
      })
    </script>
  </head>
  <body>
    @include('Admin::layouts.header')
    <!--header-->
    <div class="container-fluid">
    <!--documents-->
      <div class="row row-offcanvas row-offcanvas-left">
        @include('Admin::layouts.navigation')

        <div class="col-xs-12 col-sm-9 content">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-6 col-sm-5">
                    <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a> @yield('title','Panel Title')</h3>
                  </div>
                  <div class="col-md-6 col-sm-7" >
                    <div class="right-control-panel text-right">
                        @yield('link')
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="{{Request::segment(2) === 'dashboard' ? 'panel-body-dashboard' : 'panel-body' }}">
              @yield('content')
            </div><!-- panel body -->
          </div>
        </div><!-- content -->
      </div>
    </div>
  @include('Admin::layouts.footer')
  @yield('script')
  </body>
</html>
