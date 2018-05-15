@extends('Admin::layouts.default')

@section('title','Danh Mục')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                {!! Form::open(['route'=>'admin.category.store', 'class' =>'form']) !!}
                <div class="card-header">
                    <strong>DANH MỤC SẢN PHẨM</strong>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">Tên Danh Mục</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="description">Mô Tả</label>
                        <div class="col-md-9">
                            {!! Form::textarea('description',old('description'), ['class'=>'form-control my-editor','rows' => 1,]) !!}

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" >Hình đại diện:</label>
                        <div class="col-md-9">
                            <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                    <i class="fa fa-picture-o"></i> Chọn
                                </a>
                            </span>
                                <input id="thumbnail" class="form-control" type="hidden" name="img_url">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;">
                        </div>
                    </div>
                    <!--/.row-->
                </div>
                <div class="card-footer">
                    <div class="col-md-9 offset-md-3">
                        <a href="{!! url()->previous() !!}" class="btn btn-danger text-white"><i class="fa fa-arrow-left"></i> Back</a>
                        <button class="btn btn-success" type="submit"><i class="fa fa-dot-circle-o"></i> Save</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/js/script.js')}}"></script>
    <script>
        const url = "{{url('/')}}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');

    </script>
@stop
