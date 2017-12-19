@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(url()->previous(), 'Cancel', ['class'=>'btn btn-danger'])}}
@stop

@section('title','Edit Category')

@section('content')
    <div class="row">
      <div class="col-sm-12">
        {{Form::model($inst, ['route'=>['admin.user.update',$inst->id], 'method'=>'put', 'class' => 'form-signin' ])}}
          <h3 class="form-signin-heading">Modify User</h3>
          <div class="form-group">
              <div class="input-group">
                  <div class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                  </div>
                  {!! Form::text('name', old('name'), ['class'=> 'form-control', 'id' => 'name']) !!}
              </div>
          </div>
          <div class="form-group">
              <div class="input-group">
                  <div class="input-group-addon">
                      <i class="glyphicon glyphicon-envelope"></i>
                  </div>
                  {!! Form::email('email', old('email'), ['class'=> 'form-control', 'id' => 'email', 'disabled']) !!}
              </div>
          </div>
          <div class="form-group">
              <div class="input-group">
                  <div class="input-group-addon">
                      <i class="glyphicon glyphicon-user"></i>
                  </div>
                  {!! Form::text('username', old('username'), ['class'=> 'form-control', 'id' => 'username']) !!}
              </div>
          </div>
          <div class="form-group">
              @if(count($role))
                  <div class="radio">
                      @foreach($role as $key=>$item_role)
                          <label for="{!! $item_role !!}"><input type="radio" name="role_id" value="{!! $key !!}" {!! $inst->hasRole($item_role) ? 'checked' : null !!}> <b>{!! $item_role !!}</b></label>
                      @endforeach
                  </div>
              @else
                  {{Form::select('role_id', ['' => 'Chọn role'] + $role, '',['class' => 'form-control', 'required'] ) }}
              @endif
          </div>
          <div class="form-group">
              <button class="btn btn-lg btn-primary btn-block" type="submit">Save Changes</button>
          </div>
          @if($errors->any())
              <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                      <p>{{$error}}</p>
                  @endforeach
              </div>
              @endif
        {!! Form::close(); !!}
      </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/dist/js/script.js')}}"></script>
    <script>
    const url = "{{url('/')}}"
    init_tinymce(url);
    // BUTTON ALONE
    init_btnImage(url,'#lfm');
    // SUBMIT FORM
    function submitForm(){
     $('form').submit();
    }
    // $(document).ready(function(){
    //     $('radio[name="status"]').change(function(){
    //
    //     })
    // })
    </script>
@stop
