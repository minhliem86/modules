@extends('Admin::layouts.default')


@section('title','Sản Phẩm')

@section('css')
    <style>
        /* Mimic table appearance */
        div.album{
            margin:10px 0;
        }
        div#actions{
            margin-bottom:10px;
        }
        div.table {
            display: table;
        }
        div.table .file-row {
            display: table-row;
        }
        div.table .file-row > div {
            display: table-cell;
            vertical-align: top;
            border-top: 1px solid #ddd;
            padding: 8px;
        }
        div.table .file-row:nth-child(odd) {
            background: #f9f9f9;
        }



        /* The total progress gets shown by event listeners */
        #total-progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the progress bar when finished */
        #previews .file-row.dz-success .progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the delete button initially */
        #previews .file-row .delete {
            display: none;
        }

        /* Hide the start and cancel buttons and show the delete button */

        #previews .file-row.dz-success .start,
        #previews .file-row.dz-success .cancel {
            display: none;
        }
        #previews .file-row.dz-success .delete {
            display: block;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>SẢN PHẨM</strong>
                </div>
                {!! Form::open(['route'=>'admin.product.store', 'class' =>'form', 'files'=>true] ) !!}
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
                                        <a class="nav-link active show" data-toggle="pill" href="#name_vi" role="tab" aria-controls="pills-name_vi">VI</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#name_en" role="tab" aria-controls="pills-name_en">EN</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade active show" id="name_vi" role="tabpanel" aria-labelledby="pills-name_vi">
                                        <input type="text" class="form-control" name="name_vi">
                                    </div>
                                    <div class="tab-pane fade" id="name_en" role="tabpanel" aria-labelledby="pills-name_en">
                                        <input type="text" class="form-control" name="name_en">
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
                                    <div class="tab-pane fade" id="content_en" role="tabpanel" aria-labelledby="pills-content_en">
                                        {!! Form::textarea('content_en',old('content_en'), ['class' => 'form-control my-editor']) !!}
                                    </div>
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
                                        <input type="text" class="form-control price" name="price_vi">
                                    </div>
                                    {{--<div class="tab-pane fade" id="price_en" role="tabpanel" aria-labelledby="pills-price_en">--}}
                                        {{--<input type="text" class="form-control" name="price_en">--}}
                                    {{--</div>--}}
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
                            <label class="col-md-3 col-form-label">Hình đại diện:</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-success btn-sm text-white">
                                        <i class="fa fa-picture-o"></i> Chọn
                                    </a>
                                </span>
                                    <input id="thumbnail" class="form-control" type="hidden" name="img_url">
                                </div>
                                <img id="holder" style="margin-top:15px;max-height:100px;">
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
                                <input type="checkbox" id="seo_checking" name="seo_checking" class="custom-control-input ">
                                <label class="custom-control-label" for="seo_checking"><b>CẤU HÌNH SEO</b></label>
                            </div>
                        </div>
                        <div class="seo-container">
                            <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Keywords</label>
                                <div class="col-md-9">
                                    {!! Form::text('keywords',old('keywords'), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-3 col-form-label">Description</label>
                                <div class="col-md-9">
                                    {!! Form::text('description',old('description'), ['class' => 'form-control']) !!}
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
                                        <input id="thumbnail_meta" class="form-control" type="hidden" name="meta_img">
                                    </div>
                                    <img id="meta_preview" style="margin-top:15px;max-height:100px;">
                                </div>
                            </div>
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
@stop

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
            $("#thumb-input").fileinput({
                uploadUrl: "{!!route('admin.product.store')!!}", // server upload action
                uploadAsync: true,
                showUpload: false,
                showBrowse: false,
                showCaption: false,
                showCancel: false,
                dropZoneEnabled : true,
                browseOnZoneClick: true,
                fileActionSettings:{
                    showUpload : false,
                    showZoom: false,
                    showDrag: false,
                    showDownload: false,
                    removeIcon: '<i class="fa fa-trash text-danger"></i>',
                },
                layoutTemplates: {
                    progress: '<div class="kv-upload-progress hidden"></div>'
                }
            })

            $('.price').priceFormat({
                prefix: '',
                centsLimit:0,
//                thousandsSeparator: '',
//                clearOnEmpty: true
            })
        })
    </script>
@stop
