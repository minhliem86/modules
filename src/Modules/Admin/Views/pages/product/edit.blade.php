@extends('Admin::layouts.default')

@section('title','Quản lý Sản Phẩm')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>SẢN PHẨM</strong>
                </div>
                {!!  Form::model($inst, ['route'=>['admin.product.update',$inst->id], 'method'=>'put', 'files'=>true ])!!}
                <div class="card-body">
                    <fieldset>
                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label">Chọn Thương Hiệu</label>
                            <div class="col-md-9">
                                {!! Form::select('brand_id', ['' => '-- Chọn Thương Hiệu --'] + $brands,old('brand_id'), ['class'=> 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label">Mã Sản Phẩm</label>
                            <div class="col-md-9">
                                {!! Form::text('sku',old('sku'), ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label">Tên Sản Phẩm</label>
                            <div class="col-md-9">
                                <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="pill" href="#title_vi" role="tab" aria-controls="pills-title_vi">VI</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#title_en" role="tab" aria-controls="pills-title_en">EN</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade active show" id="title_vi" role="tabpanel" aria-labelledby="pills-title_vi">
                                        {!! Form::text('name_vi', old('name_vi'), ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="tab-pane fade" id="title_en" role="tabpanel" aria-labelledby="pills-title_en">
                                        {!! Form::text('name_en', old('name_en'), ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label">Mô Tả</label>
                            <div class="col-md-9">
                                <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="pill" href="#description_vi" role="tab" aria-controls="pills-description_vi">VI</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#description_en" role="tab" aria-controls="pills-description_en">EN</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade active show" id="description_vi" role="tabpanel" aria-labelledby="pills-description_vi">
                                        {!! Form::textarea('description_vi',old('description_vi'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="tab-pane fade" id="description_en" role="tabpanel" aria-labelledby="pills-description_en">
                                        {!! Form::textarea('description_en',old('description_en'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label">Giới Thiệu Sản Phẩm</label>
                            <div class="col-md-9">
                                <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="pill" href="#content_vi" role="tab" aria-controls="pills-content_vi">VI</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#content_en" role="tab" aria-controls="pills-content_en">EN</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade active show" id="content_vi" role="tabpanel" aria-labelledby="pills-content_vi">
                                        {!! Form::textarea('content_vi',old('content_vi'), ['class' => 'form-control my-editor']) !!}
                                    </div>
                                    {{--<div class="tab-pane fade" id="content_en" role="tabpanel" aria-labelledby="pills-content_en">--}}
                                        {{--{!! Form::textarea('content_en',old('content_en'), ['class' => 'form-control my-editor']) !!}--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label">Giá Sản Phẩm</label>
                            <div class="col-md-9">
                                <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="pill" href="#price_vi" role="tab" aria-controls="pills-price_vi">VI</a>
                                    </li>
                                    {{--<li class="nav-item">--}}
                                        {{--<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#price_en" role="tab" aria-controls="pills-price_en">EN</a>--}}
                                    {{--</li>--}}
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade active show" id="price_vi" role="tabpanel" aria-labelledby="pills-price_vi">
                                        {!! Form::text('price_vi', old('price_vi'), ['class'=>'form-control price']) !!}
                                    </div>
                                    <div class="tab-pane fade" id="price_en" role="tabpanel" aria-labelledby="pills-price_en">
                                        {!! Form::text('price_en', old('price_en'), ['class'=>'form-control price']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3 col-form-label">Số lượng nhập kho</label>
                            <div class="col-md-9">
                                {!! Form::text('quantity',old('quantity'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="description">Sắp xếp</label>
                            <div class="col-md-9">
                                {{Form::text('order',old('order'), ['class'=>'form-control'])}}
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
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-success btn-sm text-white">
                                        <i class="fa fa-picture-o"></i> Chọn
                                    </a>
                                </span>
                                    {{Form::hidden('img_url',old('img_url'), ['class'=>'form-control', 'id'=>'thumbnail' ])}}
                                </div>
                                <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset('public/uploads/'.$inst->img_url)}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Hình Chi Tiết (opt)</label>
                            <div class="col-md-9">
                                <div class="photo-container">
                                    <input type="file" name="thumb-input[]" id="thumb-input" multiple >
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-group">
                        <div class="form-group row">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" id="seo_checking" name="seo_checking" {!! $inst->metas()->count() ? 'checked' : null  !!} class="custom-control-input ">
                                <label class="custom-control-label" for="seo_checking"><b>CẤU HÌNH SEO</b></label>
                            </div>
                        </div>
                        <div class="seo-container">
                            <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Keywords</label>
                                <div class="col-md-9">
                                    {!! Form::text('keywords',$inst->metas()->count() ? $inst->metas()->first()->meta_keyword : '', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Description</label>
                                <div class="col-md-9">
                                    {!! Form::text('description',$inst->metas()->count() ? $inst->metas()->first()->meta_description : '', ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" >FB Sharing (600x315):</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <a id="lfm_meta" data-input="thumbnail_meta" data-preview="meta_preview" class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o"></i> Chọn
                                        </a>
                                    </span>
                                        {{Form::hidden('meta_img',$inst->metas()->count() ? $inst->metas()->first()->meta_img : '', ['class'=>'form-control', 'id'=>'thumbnail_meta' ])}}
                                    </div>

                                    <img id="meta_preview" style="margin-top:15px;max-height:100px;"{!! $inst->metas()->count() ? 'src="'.asset('public/uploads/'.$inst->metas()->first()->meta_img).'"' : null  !!} >
                                </div>
                            </div>
                            {!! Form::hidden('meta_id',$inst->metas()->count() ? $inst->metas()->first()->id : '') !!}
                        </div>
                    </fieldset>


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

    <!--BT Upload-->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/js/plugins/bootstrap-input/css/fileinput.min.css">
    <script src="{{asset('/public/assets/admin')}}/js/plugins/bootstrap-input/js/plugins/sortable.min.js"></script>
    <script src="{{asset('/public/assets/admin')}}/js/plugins/bootstrap-input/js/plugins/purify.min.js"></script>
    <script src="{{asset('/public/assets/admin')}}/js/plugins/bootstrap-input/js/fileinput.min.js"></script>

    <!--PRICE FORMAT -->
    <script src="{{asset('/public/assets/admin')}}/js/jquery.priceformat.min.js"></script>

    <script>
        const url = "{{url('/')}}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');
        init_btnImage(url,'#lfm_meta');

        $(document).ready(function(){
            $(document).ready(function(){
                $("#thumb-input").fileinput({
                    uploadUrl: "{!!route('admin.product.store')!!}", // server upload action
                    uploadAsync: false,
                    showUpload: false,
                    showCancel: false,
                    showCaption: false,
                    dropZoneEnabled : true,
                    showBrowse: false,
                    overwriteInitial: false,
                    browseOnZoneClick: true,
                    fileActionSettings:{
                        showUpload : false,
                        showZoom: false,
                        showDrag: false,
                        showDownload: false,
                        removeIcon: '<i class="fa fa-trash text-danger"></i>',
                    },
                    initialPreview: [
                        @foreach($inst->photos as $photo)
                            "{!!asset($photo->thumb_url)!!}",
                        @endforeach
                    ],
                    initialPreviewAsData: true,
                    initialPreviewFileType: 'image',
                    initialPreviewConfig: [
                            @foreach($inst->photos as $item_photo)
                        {'url': '{!! route("admin.product.AjaxRemovePhoto") !!}', key: "{!! $item_photo->id !!}", caption: "{!! $item_photo->filename !!}"},
                        @endforeach
                    ],
                    layoutTemplates: {
                        progress: '<div class="kv-upload-progress hidden"></div>'
                    },
                });
            })
            /*PRICE FORMAT*/
            $('.price').priceFormat({
                prefix: '',
                centsLimit:0,
            })
            /*CHANGE STATUS*/
            $(document).on('change', 'input[name=status]', function(){
                if($(this).prop('checked')){
                    $(this).val(1);
                }else{
                    $(this).val(0);
                }
            })
        })

        function updatePhoto(e, id){
            var value = e.parentNode.previousElementSibling.childNodes[1].value;
            $.ajax({
                url: '{{route("admin.product.AjaxUpdatePhoto")}}',
                type: 'POST',
                data:{id_photo: id, value: value, _token:$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
                    if(!data.error){
                        alertify.success('Cập nhật thay đổi.');
                    }
                }
            })
        }
    </script>



    </script>
@stop
