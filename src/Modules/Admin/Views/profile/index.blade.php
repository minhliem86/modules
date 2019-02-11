@extends('Admin::layouts.default')

@section('title','Profile')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Profile</strong>
                </div>
                <div class="card-body pb-4">
                    <ul id="myTab1" class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="pill" role="tab" aria-controls="profile"><b>Information</b></a></li>
                        <li class="nav-item"><a class="nav-link" href="#changePass" data-toggle="pill" role="tab" aria-controls="changePass"><b>Change Password</b></a></li>
                    </ul>

                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active show " id="profile">
                            <table width="100%" class="table table-striped profile-table">
                                <tr>
                                    <td width="50%">
                                        <b><p class="title">Name:</p></b>
                                    </td>
                                    <td>
                                        <p>{!! auth()->user()->name !!}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <b><p class="title">Email:</p></b>
                                    </td>
                                    <td>
                                        <p>{!! auth()->user()->email !!}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <b><p class="title">Create Date:</p></b>
                                    </td>
                                    <td>
                                        <p>{!! auth()->user()->created_at !!}</p>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="changePass">
                            {{Form::open(['route' =>'admin.changePass.postChangePass', 'class' =>'form-changepass'  ] )}}
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
    </div>
    @if($errors->any())
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
@stop

@section('script')
    <script src="{{asset('/public/assets/admin')}}/js/jquery.validate.min.js"></script>
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
