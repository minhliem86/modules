<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Bootflat-Admin Template</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon_16.ico"/>
    <link rel="bookmark" href="favicon_16.ico"/>
    <!-- site css -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/css/site.min.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/css/customize.min.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
    <!-- <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'> -->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/site.min.js"></script>

    <!-- Bootstrap Select  -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-select/css/bootstrap-select.min.css">
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>

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
    <style>
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #303641;
        color: #C1C3C6
      }
    </style>
  </head>
  <body>
    <div class="container">
      <form class="form-signin" id="form-role" role="form" action="{{route('admin.postCreateRole')}}" method="POST">
        {{Form::token()}}
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
  </body>
</html>
