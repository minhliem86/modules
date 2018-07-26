@extends('Admin::layouts.main-layout')

@section('link')

@stop

@section('title','Create New User')

@section('content')
    <div class="row">
      <div class="col-sm-12">
          <form class="form-signin" role="form" action="{{route('admin.user.createByAdmin')}}" method="POST">
              {{Form::token()}}
              {!! Form::hidden('form_type', 'dashboard_create') !!}
              <h3 class="form-signin-heading">Register New User</h3>
              <div class="form-group">
                  <div class="input-group">
                      <div class="input-group-addon">
                          <i class="glyphicon glyphicon-user"></i>
                      </div>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" autocomplete="off" value="{{old('name')}}" />
                  </div>
              </div>
              <div class="form-group">
                  <div class="input-group">
                      <div class="input-group-addon">
                          <i class="glyphicon glyphicon-envelope"></i>
                      </div>
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" value="{{old('email')}}" />
                  </div>
              </div>
              {{--<div class="form-group">--}}
                  {{--<div class="input-group">--}}
                      {{--<div class="input-group-addon">--}}
                          {{--<i class="glyphicon glyphicon-user"></i>--}}
                      {{--</div>--}}
                      {{--<input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" value="{{old('username')}}" />--}}
                  {{--</div>--}}
              {{--</div>--}}

              <div class="form-group">
                  <div class="input-group">
                      <div class="input-group-addon">
                          <i class=" glyphicon glyphicon-lock "></i>
                      </div>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />
                  </div>
              </div>
              <div class="form-group">
                  <div class="input-group">
                      <div class="input-group-addon">
                          <i class=" glyphicon glyphicon-lock "></i>
                      </div>
                      <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation" autocomplete="off" />
                  </div>
              </div>
              <div class="form-group">
                  <div class="input-group">
                      <div class="input-group-addon">
                          <i class=" glyphicon glyphicon-user "></i>
                      </div>
                      {{Form::select('role_id', ['' => 'Chọn role'] + $role, '',['class' => 'form-control', 'required'] ) }}
                  </div>
              </div>
              <div class="form-group">
                  <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
              </div>
              @if($errors->any())
                  <div class="alert alert-danger">
                      @foreach($errors->all() as $error)
                          <p>{{$error}}</p>
                      @endforeach
                  </div>
              @endif

          </form>
      </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/dist/js/script.js')}}"></script>
@stop
