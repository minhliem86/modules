<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,Angular 2,Angular4,Angular 4,jQuery,CSS,HTML,RWD,Dashboard,React,React.js,Vue,Vue.js">
    <link rel="shortcut icon" href="{!! asset('public/assets/admin') !!}/img/favicon.ico">
    <title>CoreUI - Admin Template</title>

    <!-- Icons -->
    <link href="{!! asset('public/assets/admin') !!}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{!! asset('public/assets/admin') !!}/css/simple-icon/css/simple-line-icons.css" rel="stylesheet">
    <link href="{!! asset('public/assets/admin') !!}/css/flat-icon/css/flag-icon.min.css" rel="stylesheet">


    <!-- Main styles for this application -->
    <link href="{!! asset('public/assets/admin') !!}/css/style.css" rel="stylesheet">
    <!-- Styles required by this views -->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="py-4">
                <form class="form-signin" role="form" action="{{url('/admin/password/email')}}" method="POST">
                    {{Form::token()}}
                    <h3 class="form-signin-heading">Nhập Email Của Bạn</h3>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="glyphicon glyphicon-envelope"></i>
                            </div>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Send me reset code</button>
                    </div>
                    <a href="{!! url('/admin/login') !!}" class="btn-block text-right">Login page</a>
                    @if(Session::has('status'))
                        <div class="alert alert-success">
                            <p>{!! Session::get('status') !!}) </p>
                        </div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            <p>{!!  $errors->first('email') !!} </p>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap and necessary plugins -->
<script src="{!! asset('public/assets/admin') !!}/js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="{!! asset('public/assets/admin') !!}/js/bootstrap.min.js"></script>
</body>
</html>
