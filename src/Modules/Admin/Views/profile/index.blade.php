@extends('Admin::layouts.main-layout')

@section('title','Profile')

@section('content')
@if($errors->has())
<div class="alert alert-danger alert-dismissable">
    @foreach($errors->all() as $error)
      <p>{{$error}}</p>
     @endforeach
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissable">
  <p>{{Session::get('error')}}</p>
</div>
@endif
<div class="row">
      <div class="col-sm-8 col-sm-offset-2">
          <div class="panel">
              <ul id="myTab1" class="nav nav-tabs nav-justified">
                  <li class="active"><a href="#profile" data-toggle="tab"><b>Profile</b></a></li>
                  <li><a href="#changePass" data-toggle="tab"><b>Change Password</b></a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="profile">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="profile-table">
                            <tr>
                                <td width="50%">
                                    <p class="title">Name:</p>
                                </td>
                                <td>
                                    <p>{{Auth::user()->name}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <p class="title">Email:</p>
                                </td>
                                <td>
                                    <p>{{Auth::user()->email}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <p class="title">Create Date:</p>
                                </td>
                                <td>
                                    <p>{{date_format(Auth::user()->created_at, 'd-m-Y')}}</p>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="changePass">
                        {{Form::open(['route' =>[ 'admin.changePass.postChangePass'], 'class' =>'form-changepass'  ] )}}
                            <div class="form-group">
                                <label for="old_password">Old Password</label>
                                {{Form::password('old_password', ['class'=>'form-control', 'id' =>'old_password' ])}}
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                {{Form::password('new_password', ['class'=>'form-control', 'id' =>'new_password' ])}}
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirm">New Password Confirmation</label>
                                {{Form::password('new_password_confirmation', ['class'=>'form-control', 'id' =>'new_password_confirm' ])}}
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Change Password</button>
                            </div>

                        {{Form::close()}}
                    </div>
                </div>
          </div>
      </div>
  </div>
@stop

@section('script')
    <script src="{{asset('/public/assets/admin')}}/dist/js/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.form-changepass').validate({
                rules:{
                    'old_password': 'required',
                    'new_password': {
                        required: true,
                        minlength: 6
                    },
                    'new_password_confirmation': 'required'
                }
            })
        })
    </script>
@stop
