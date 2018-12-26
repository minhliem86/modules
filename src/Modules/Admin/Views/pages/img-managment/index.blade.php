@extends('Admin::layouts.default')

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <p>{{Session::get('error')}}</p>
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <p>{{Session::get('success')}}</p>
        </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="wrap-title">
                            <strong>QUẢN LÝ HÌNH ẢNH</strong>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <iframe src="{!! url('laravel-filemanager') !!}" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
@stop
