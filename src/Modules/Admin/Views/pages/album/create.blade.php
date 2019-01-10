@extends('Admin::layouts.default')

@section('title','Thư Viện Hình')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                {!! Form::open(['route'=>'admin.album.store', 'class' =>'form', 'files' => true]) !!}
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
                            <label class="col-md-3 col-form-label" for="title">Tên Danh Mục</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="title">
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
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/js/script.js')}}"></script>

    <!--BT Upload-->
    <link rel="stylesheet" href="{!!asset('/public/assets/admin')!!}/js/plugins/bootstrap-input/css/fileinput.min.css">
    <script src="{!!asset('/public/assets/admin')!!}/js/plugins/bootstrap-input/js/plugins/sortable.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/js/plugins/bootstrap-input/js/plugins/purify.min.js"></script>
    <script src="{!!asset('/public/assets/admin')!!}/js/plugins/bootstrap-input/js/fileinput.min.js"></script>
    <script>
        const url = "{{url('/')}}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');
        init_btnImage(url,'#lfm-meta');

        var footerTemplate = '<div class="file-thumbnail-footer" style ="height:94px">\n' +
            '<input name="title_img[]" class="kv-input kv-new form-control input-sm form-control-sm text-center " value="{caption}" placeholder="Enter caption..."> ' +
            '   <div class="small" style="margin:15px 0 2px 0">{size}</div> {progress}\n{indicator}\n{actions}\n' +
            '</div>';

        $("#photo-input").fileinput({
            theme: 'fas',
            uploadUrl: "{!!route('admin.album.store')!!}", // server upload action
            uploadAsync: false,
            showUpload: false,
            showBrowse: false,
            showCaption: false,
            showCancel: false,
            dropZoneEnabled: true,
            browseOnZoneClick: true,
            frameClass: 'krajee-default col-lg-2 col-md-3 col-sm-3',
            fileActionSettings: {
                showUpload: false,
                showZoom: false,
                showDownload: false,
                removeIcon: '<i class="fa fa-trash text-danger"></i>',
                indicatorNew: '<i class="fa fa-upload text-warning" aria-hidden="true"></i>'
            },
            layoutTemplates: {
                progress: '<div class="kv-upload-progress hidden"></div>',
                footer: footerTemplate,
            },
            previewSettings: {
                image: {width: "200px", height: "150px", 'max-width': "120px", 'max-height': "100%"},
            },
        })

    </script>
@stop
