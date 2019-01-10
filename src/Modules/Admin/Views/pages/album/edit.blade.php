@extends('Admin::layouts.default')

@section('title','Album')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                {!!  Form::model($inst, ['route'=>['admin.album.update',$inst->id], 'method'=>'put', 'files'=> true ])!!}
                <div class="card-header">
                    <strong>Thư Viện Hình</strong>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $error)
                                {!! $error !!}
                            @endforeach
                        </div>
                    @endif
                    <fieldset>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="title">Tên Album</label>
                            <div class="col-md-9">
                                {!! Form::text('title', old("title"),['class' => "form-control"]) !!}
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
                                <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset(env("PATH_PHOTO").'/'.$inst->img_url)}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Thư Viện Hình</label>
                        </div>
                        <div class="form-group">
                            <div class="photo-container">
                                <input type="file" name="photo-input[]" id="photo-input" multiple >
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
@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/js/script.js')}}"></script>

    <!--BT Upload-->
    <link rel="stylesheet" href="{!!asset('/public/assets/admin')!!}/js/plugins/bootstrap-input/css/fileinput.min.css">
    <script src="{!!asset('/public/assets/admin')!!}/js/plugins/bootstrap-input/js/plugins/sortable.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/js/plugins/bootstrap-input/js/plugins/purify.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/js/plugins/bootstrap-input/js/fileinput.min.js"></script>

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="{!! asset('/public/assets/admin') !!}/js/plugins/alertify/alertify.css">
    <link rel="stylesheet" href="{!! asset('/public/assets/admin') !!}/js/plugins/alertify/bootstrap.min.css">
    <script src="{!! asset('/public/assets/admin') !!}/js/plugins/alertify/alertify.js"></script>

    <script>
        const url = "{{url('/')}}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');

        $(document).on('change', 'input[name=status_check]', function(){
            if($(this).prop('checked')){
                $('input[name=status]').val(1);
            }else{
                $('input[name=status]').val(0);
            }
        })

        @if($inst->meta_configs && $inst->meta_configs->first())
            $("input[name=seo_checking]").prop('checked', true);
            $("div.seo-container").show();
        @endif

        var cap = '<div class="file-caption" tabindex="500">\n' +
            '{CUSTOM_CAPTION}\n' +
            '</div>';
        var footerTemplate = '<div class="file-thumbnail-footer" style ="height:94px">\n' +
            cap +
            '   <div class="small" style="margin:15px 0 2px 0">{size}</div> {progress}\n{indicator}\n{actions}\n' +
            '</div>';

        $("#photo-input").fileinput({
            theme: 'fas',
            uploadUrl: "{!!route('admin.album.store')!!}", // server upload action
            uploadAsync: false,
            overwriteInitial: false,
            deleteUrl: '{!! route("admin.album.AjaxRemovePhoto") !!}',
            showUpload: false,
            showBrowse: false,
            showCaption: false,
            showCancel: false,
            dropZoneEnabled: true,
            browseOnZoneClick: true,
            frameClass: 'krajee-default col-lg-2 col-md-3 col-sm-3 krajee-lp',
            fileActionSettings: {
                showUpload: false,
                showZoom: false,
                showDownload: false,
                removeIcon: '<i class="fa fa-trash text-danger"></i>',
                indicatorNew: '<i class="fa fa-upload text-warning" aria-hidden="true"></i>',
                dragIcon: '<i class="fa fa-arrows" aria-hidden="true"></i>',
                dragSettings: {
                    onEnd: function(event){
                        // console.log(event.item.attributes);
                    }
                }
            },
            layoutTemplates: {
                progress: '<div class="kv-upload-progress hidden"></div>',
                footer: footerTemplate,
            },
            previewSettings: {
                image: {width: "100%", height: "150px", 'max-width': "120px", 'max-height': "100%"},
            },
            @if($inst->photos)
            initialPreview: [
                @foreach($inst->photos()->orderBy('order','asc')->get() as $photo)
                    '<img src= "{!!asset($photo->thumb_url)!!}" class="img-fluid" alt="{!! $photo->filename !!}" style="max-height:100%; margin:0 auto;">',
                @endforeach
            ],
            initialPreviewConfig: [
                    @foreach($inst->photos()->orderBy('order','asc')->get() as $item_photo)
                {
                    key: "{!! $item_photo->id !!}",
                    caption: "{!! $item_photo->filename !!}",
                    width:"120px",
                    frameAttr: {
                        'id' : '{!! $item_photo->id !!}' ,
                        'value' : '{!! $item_photo->order !!}' ,
                    },
                    extra: {
                        sortUrl: '{!! route("admin.album.AjaxRemovePhoto") !!}'
                    }
                },
                @endforeach
            ],
            previewThumbTags: {
                '{CUSTOM_CAPTION}': '<input type="text" name="title_img[]" placeholder="Enter Caption ..."  class="form-control" />',        // no value
            },
            initialPreviewThumbTags: [
                @foreach($inst->photos()->orderBy('order','asc')->get() as $item_photo)
                {'{CUSTOM_CAPTION}': '<span>{!! $item_photo->title !!}</span>'},
                @endforeach
            ],
            uploadExtraData: function (){
                return 'test';
            }
            @endif


        }).on('filedeleted', function(event, key, jqXHR, data){
            if(jqXHR.status == 200){
                alertify.success('Photo is deleted.')
            }else{
                alertify.success('Have Error in processing')
            }
        }).on('filesorted', function (event, params){
            console.log(params);
            $.each(params.stack, function (index, value) {
                if(index == params.newIndex){
                    $.ajax({
                        url: '{!! route("admin.album.AjaxUpdatePhoto") !!}',
                        type: 'POST',
                        data: {id_photo: value.key, value: params.newIndex + 1 },
                        success: function (res) {
                            console.log(value.frameAttr.value)
                        }
                    })
                }
                if(index == params.oldIndex){

                    $.ajax({
                        url: '{!! route("admin.album.AjaxUpdatePhoto") !!}',
                        type: 'POST',
                        data: {id_photo: value.key, value: params.oldIndex + 1 },
                        success: function (res) {
                            console.log(value.frameAttr.value)
                        }
                    })
                }
            })
            alertify.success('Photo is Rearranged.')
        }).on('fileloaded', function (event, file, previewID, index, reader) {
            console.log(file, reader);
        })

    </script>
@stop
