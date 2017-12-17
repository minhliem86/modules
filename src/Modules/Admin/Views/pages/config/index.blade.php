@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Configuration Google Analytic')

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
            @if($data->isEmpty())
                <form method="POST" action="{{route('admin.config')}}" id="form" role="form" class="form-horizontal form">
                    {!! Form::token() !!}
                    <div class="form-group">
                        <label class="col-md-2 control-label">Google Analytic ID (Ex: 157384488)</label>
                        <div class="col-md-10">
                            <input type="text" placeholder="GA ID" id="ga_id" class="form-control" name="ga_id">
                        </div>
                    </div>
                </form>
            @else
                <form method="PUT" action="{{route('admin.config')}}" id="form" role="form" class="form-horizontal form">
                    {!! Form::token() !!}
                    <div class="form-group">
                        <label class="col-md-2 control-label">Google Analytic ID (Ex: 157384488)</label>
                        <div class="col-md-10">
                            {!! Form::text('ga_id',$data['ga_id'], ['class' => 'form-control'] ) !!}
                        </div>
                    </div>
                    {!! Form::hidden('title', $data['title']00) !!}
                </form>
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
