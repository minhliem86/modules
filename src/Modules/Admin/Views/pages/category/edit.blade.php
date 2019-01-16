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
                    <fieldset>
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
                    </fieldset>
                    <fieldset>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="meta_config" name="seo_checking">
                            <label class="custom-control-label" for="meta_config"><b>SEO SETUP</b></label>
                        </div>
                        <div class="wrap-seo seo-container">
                            {!! Form::hidden('meta_config_id',$inst->meta_configs->first() ? $inst->meta_configs->first()->id : '') !!}
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Meta Keywords:</label>
                                <div class="col-md-9">
                                    {!! Form::text('meta_keywords', $inst->meta_configs->first() ? $inst->meta_configs->first()->meta_keyword : "", ['id' => 'meta_keywords' ,'class' => 'form-control', 'placeholder' => 'Từ khóa bài viết (ngăn cách bởi dấu `,`. Ex: quầy tây, quần kaki)']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Meta Description:</label>
                                <div class="col-md-9">
                                    {!! Form::text('meta_description', $inst->meta_configs->first() ? $inst->meta_configs->first()->meta_description : "", ['id' => 'meta_description' ,'class' => 'form-control', 'placeholder' => 'Mô tả bài viết']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">SEO's Photo:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                     <span class="input-group-btn">
                                       <a id="lfm-meta" data-input="thumbnail_meta" data-preview="holder_meta" class="btn btn-primary btn-sm text-white">
                                         <i class="fa fa-picture-o"></i> Choose
                                       </a>
                                     </span>
                                        {{Form::hidden('meta_img',$inst->meta_configs->first() ? $inst->meta_configs->first()->meta_img : "", ['class'=>'form-control', 'id'=>'thumbnail_meta' ])}}
                                    </div>
                                    <img id="holder_meta" style="margin-top:15px;max-height:100px;" src="{{$inst->meta_configs->first() ? asset('public/storage/'.$inst->img_url) : ''}}">
                                </div>
                            </div>
                        </div>
                    </fieldset>
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
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/js/script.js')}}"></script>
    <script>
        const url = "{{url('/')}}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');

        init_btnImage(url,'#lfm-meta');

        $(document).on('change', 'input[name=status_check]', function(){
            if($(this).prop('checked')){
                $('input[name=status]').val(1);
            }else{
                $('input[name=status]').val(0);
            }
        })

        @if($inst->metable->first())
            $("input[name=seo_checking]").prop('checked', true);
            $("div.seo-container").show();
        @endif

    </script>
@stop
