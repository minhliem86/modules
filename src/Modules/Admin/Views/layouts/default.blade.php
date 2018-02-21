<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.10
 * @link http://coreui.io
 * Copyright (c) 2018 creativeLabs Łukasz Holeczek
 * @license MIT
 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,Angular 2,Angular4,Angular 4,jQuery,CSS,HTML,RWD,Dashboard,React,React.js,Vue,Vue.js">
    <link rel="shortcut icon" href="{!! asset('public/assets/admin') !!}/img/favicon.png">
    <title>CoreUI - Admin Template</title>

    <!-- Icons -->
    <link href="{!! asset('public/assets/admin') !!}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{!! asset('public/assets/admin') !!}/css/simple-icon/css/simple-line-icons.css" rel="stylesheet">
    <link href="{!! asset('public/assets/admin') !!}/css/flat-icon/css/flag-icon.min.css" rel="stylesheet">


    <!-- Main styles for this application -->
    <link href="{!! asset('public/assets/admin') !!}/css/style.css" rel="stylesheet">
    <!-- Styles required by this views -->

</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'					- Fixed Header

// Brand options
1. '.brand-minimized'       - Minimized brand (Only symbol)

// Sidebar options
1. '.sidebar-fixed'					- Fixed Sidebar
2. '.sidebar-hidden'				- Hidden Sidebar
3. '.sidebar-off-canvas'		- Off Canvas Sidebar
4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
5. '.sidebar-compact'			  - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'			- Fixed Aside Menu
2. '.aside-menu-hidden'			- Hidden Aside Menu
3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

// Breadcrumb options
1. '.breadcrumb-fixed'			- Fixed Breadcrumb

// Footer options
1. '.footer-fixed'					- Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden {!! Request::segment(2) == 'login' ? 'flex-row align-items-center': null !!}">
@include('Admin::layouts.header')

<div class="app-body">
@include('Admin::layouts.sidebar')

<!-- MAIN CONTENT-->
    <main class="main">
        <div class="container-fluid">
            <div class="animated fadeIn">
                @yield('content')
            </div>
        </div>
    </main>
    <!-- END -->
</div>

@include('Admin::layouts.footer')

<!-- Bootstrap and necessary plugins -->
<script src="{!! asset('public/assets/admin') !!}/js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="{!! asset('public/assets/admin') !!}/js/bootstrap.min.js"></script>
<script src="{!! asset('public/assets/admin') !!}/js/pace.min.js"></script>

<!-- Plugins and scripts required by all views -->
<script src="{!! asset('public/assets/admin') !!}/js/Chart.js"></script>

<!-- CoreUI main scripts -->

<script src="{!! asset('public/assets/admin') !!}/js/app.js"></script>

<!-- Plugins and scripts required by this views -->

<!-- Custom scripts required by this view -->
{{--<script src="{!! asset('public/assets/admin') !!}/js/views/main.js"></script>--}}
@yield("script")

</body>
</html>