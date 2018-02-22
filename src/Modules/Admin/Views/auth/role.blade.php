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
    <link rel="shortcut icon" href="{!! asset('public/assets/admin') !!}/img/favicon.png">
    <title>CoreUI - Admin Template</title>

    <!-- Icons -->
    <link href="{!! asset('public/assets/admin') !!}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{!! asset('public/assets/admin') !!}/css/simple-icon/css/simple-line-icons.css" rel="stylesheet">
    <link href="{!! asset('public/assets/admin') !!}/css/flat-icon/css/flag-icon.min.css" rel="stylesheet">


    <!-- Main styles for this application -->
    <link href="{!! asset('public/assets/admin') !!}/css/style.css" rel="stylesheet">
    <!-- Styles required by this views -->

    {{--<style>--}}
        {{--body {--}}
            {{--padding-top: 40px;--}}
            {{--padding-bottom: 40px;--}}
            {{--background-color: #303641;--}}
            {{--color: #C1C3C6--}}
        {{--}--}}
    {{--</style>--}}
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <form class="form-signin" id="form-role" role="form" action="{{route('admin.postCreateRole')}}" method="POST">
                            {!!  Form::token()!!}
                            <fieldset class="role">
                                <legend class="form-signin-heading">Register New Role</legend>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Role" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="role_display" id="role_display" placeholder="Display Name" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <textarea name="role_description" rows="3" class="form-control" placeholder="Role description (Opt)..."></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block" id="btn-role" type="button">Create Role</button>
                                </div>
                                <div id="role-show"></div>
                            </fieldset>

                            <fieldset class="permission">
                                <legend class="form-signin-heading">Register New Permission</legend>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="permission_name" id="permission_name" placeholder="Permission" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="display_pers" id="display_pers" placeholder="Display Name" autocomplete="off" />
                                </div>
                                <div class="form-group">
                                    <textarea name="permission_description" rows="3" class="form-control" placeholder="Permission description (Opt)..."></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block" id="btn-permission" type="button">Create Permission</button>
                                </div>

                                <div id="permission-show"></div>
                            </fieldset>

                            <fieldset class="assign">
                                <legend class="form-signin-heading">Assign Role & Permission</legend>
                                <div class="form-group" id="role_select">
                                    @include('Admin::ajax.ajaxRole')
                                </div>
                                <div class="form-group" id="permission_select">
                                    @include('Admin::ajax.ajaxPermission')
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block" name="btn-submit" type="submit">Create Permission</button>
                                </div>
                                @if(!$errors->isEmpty())
                                    <div class="form-group">
                                        <div class="alert alert-danger">
                                            @foreach($errors->all() as $error)
                                                <p>{{$error}}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif


                            </fieldset>

                        </form>
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
<script>
    $(document).ready(function(){
        // CREATE ROLE
        $('#btn-role').click(function(){
            const rolename = $('input[name="role_name"]').val();
            const display_name = $('input[name="role_display"]').val();
            const description = $('textarea[name="role_description"]').val();
            $.ajax({
                url: "{{route('admin.ajaxCreateRole')}}",
                type: 'POST',
                data: {name: rolename, display_name: display_name, description: description,  _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(data){
                    $('input[name="role_name"]').val('');
                    $('input[name="role_display"]').val('');
                    $('textarea[name="role_description"]').val('');
                    if(data.error){
                        $('#role-show').append(`<div class="alert alert-danger alert-ajax">${data.rs.name}</div>`);
                    }else{
                        $('#role-show').append(`<div class="alert alert-success alert-ajax">${data.rs}</div>`);
                        $('#role_select').empty();
                        $('#role_select').append(data.role);
                    }
                    hideAlert('.alert-ajax');
                },
            })
        });

        // CREATE PERMISSION
        $('#btn-permission').click(function(){
            const per_name = $('input[name="permission_name"]').val();
            const display_pers = $('input[name="display_pers"]').val();
            const per_description = $('textarea[name="permission_description"]').val();
            $.ajax({
                url: "{{route('admin.ajaxCreatePermission')}}",
                type: 'POST',
                data: {name: per_name, display_name: display_pers, description: per_description,  _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(data){
                    $('input[name="permission_name"]').val('');
                    $('input[name="display_pers"]').val('');
                    $('textarea[name="permission_description"]').val('');
                    if(data.error){
                        $('#permission-show').append(`<div class="alert alert-danger alert-ajax">${data.rs.name}</div>`);

                    }else{
                        $('#permission-show').append(`<div class="alert alert-success alert-ajax">${data.rs}</div>`);
                        $('#permission_select').empty();
                        $('#permission_select').append(data.per);
                    }
                    hideAlert('.alert-ajax');
                },
            })
        });

    })

    function hideAlert(item){
        setTimeout(function() {
            $(item).fadeOut();
        }, 3000)
    }
</script>

</body>
</html>
