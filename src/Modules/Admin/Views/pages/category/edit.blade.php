@extends('Admin::layouts.default')

@section('title','Danh Mục')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                {!!  Form::model($inst, ['route'=>['admin.category.update',$inst->id], 'method'=>'put' ])!!}
                <div class="card-header">
                    <strong>DANH MỤC SẢN PHẨM</strong>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="name">Tên Danh Mục</label>
                        <div class="col-md-9">
                            {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="description">Mô Tả</label>
                        <div class="col-md-9">
                            {!! Form::textarea('description',old('description'), ['class'=>'form-control my-editor','rows' => 1,]) !!}

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="description">Sắp xếp</label>
                        <div class="col-md-9">
                            {{Form::text('order',old('order'), ['class'=>'form-control', 'placeholder'=>'order'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="description">Trạng thái</label>
                        <div class="col-md-9">
                            <label class="switch switch-icon switch-success-outline">
                                <input type="checkbox" class="switch-input" name="status" value="{!! $inst->status ? 1 : 0 !!}" {!! $inst->status ? "checked" : null  !!} data-id="{!! $inst->id !!}">
                                <span class="switch-label" data-on="" data-off=""></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Hình đại diện:</label>
                        <div class="col-md-9">
                            <div class="input-group">
                             <span class="input-group-btn">
                               <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary btn-sm text-white">
                                 <i class="fa fa-picture-o"></i> Choose
                               </a>
                             </span>
                                {{Form::hidden('img_url',old('img_url'), ['class'=>'form-control', 'id'=>'thumbnail' ])}}
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset('public/uploads/'.$inst->img_url)}}">
                        </div>
                    </div>
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

        $(document).on('change', 'input[name=status]', function(){
            if($(this).prop('checked')){
                $(this).val(1);
            }else{
                $(this).val(0);
            }
        })

    </script>
@stop
