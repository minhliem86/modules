@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Company Information')

@section('content')
    @if(Session::has('error'))
    <div class="alert alert-danger alert-dismissable">
      <p>{!!Session::get('error')!!}</p>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
      <p>{!!Session::get('success')!!}</p>
    </div>
    @endif
    <div class="row">
      <div class="col-sm-12">
        @if(!$inst)
        <form method="POST" action="{{route('admin.company.index')}}" id="form" role="form" class="form-horizontal form">
          {{Form::token()}}
          <div class="form-group">
            <label class="col-md-2 control-label">Địa chỉ</label>
            <div class="col-md-10">
              <input type="text" required="" placeholder="Address" id="address" class="form-control" name="address">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Email</label>
            <div class="col-md-10">
              <input type="text" required="" placeholder="Email" id="email" class="form-control" name="email">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Điện thoại</label>
            <div class="col-md-10">
              <input type="text" required="" placeholder="Phone Number" id="phone" class="form-control" name="phone">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Bản đồ</label>
            <div class="col-md-10">
              <input type="text" required="" placeholder="Map" id="map" class="form-control" name="map">
            </div>
          </div>
        </form>
        @else
        {{Form::model($inst,['route' =>['admin.company.index', $inst->id], 'method'=>'PUT', 'class'=>'form form-horizontal'])}}
          <div class="form-group">
            <label class="col-md-2 control-label">Địa chỉ</label>
            <div class="col-md-10">
              {{Form::text('address',old($inst->address),['class'=>'form-control', 'placeholder'=>'Address', 'required'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Email</label>
            <div class="col-md-10">
              {{Form::text('email',old($inst->email),['class'=>'form-control', 'placeholder'=>'Email', 'required'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Điện thoại</label>
            <div class="col-md-10">
              {{Form::text('phone',old($inst->phone),['class'=>'form-control', 'placeholder'=>'Phone', 'required'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Bản đồ</label>
            <div class="col-md-10">
              {{ Form::text('map',old($inst->map),['class'=>'form-control']) }}
            </div>
          </div>
        {{Form::close()}}
        @endif
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
        function hideAlert(a){
            setTimeout(function(){
                $(a).fadeOut();
            },2000)
        }
        $(document).ready(function(){
          hideAlert('.alert');
        });
    </script>
@stop
