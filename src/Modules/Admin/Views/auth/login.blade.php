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

<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <h1>Login</h1>
                        <p class="text-muted">Sign In to your account</p>
                        {!! Form::open(['route'=>'admin.login.post', 'class' =>'form']) !!}
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-envelope"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Email" name="email">
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary px-4">Login</button>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{!! url('/admin/password/reset') !!}" class="btn btn-link px-0">Quên Mật Khẩu?</a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{$error}}</p>
                                @endforeach
                            </div>
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                <p>{{Session::get('success')}}</p>
                            </div>
                        @endif
                    </div>
                </div>

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