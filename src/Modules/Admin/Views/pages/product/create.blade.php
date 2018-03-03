@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Quản lý Sản Phẩm')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Company</strong>
                    <small>Form</small>
                </div>
                {!! Form::open() !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" class="form-control" id="company" placeholder="Enter your company name">
                    </div>

                    <div class="form-group">
                        <label for="vat">VAT</label>
                        <input type="text" class="form-control" id="vat" placeholder="PL1234567890">
                    </div>

                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" id="street" placeholder="Enter street name">
                    </div>

                    <div class="row">

                        <div class="form-group col-sm-8">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" placeholder="Enter your city">
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="postal-code">Postal Code</label>
                            <input type="text" class="form-control" id="postal-code" placeholder="Postal Code">
                        </div>

                    </div>
                    <div class="form-group">
                        <label >Hình đại diện:</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-success">
                                    <i class="fa fa-picture-o"></i> Chọn
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="hidden" name="img_url">
                        </div>
                        <img id="holder" style="margin-top:15px;max-height:100px;">
                    </div>
                    <!--/.row-->

                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" id="country" placeholder="Country name">
                    </div>

                </div>
                <div class="card-footer">
                    <a class="btn btn-sm btn-warning text-white" href="{!! url()->previous() !!}"><i class="fa fa-backward"></i> Cancel</a>
                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Save</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script src="{{asset('public')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('public/assets/admin/dist/js/script.js')}}"></script>

    <!--BT Upload-->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-input/css/fileinput.min.css">
    <script src="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-input/js/plugins/sortable.min.js"></script>
    <script src="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-input/js/plugins/purify.min.js"></script>
    <script src="{{asset('/public/assets/admin')}}/dist/js/plugins/bootstrap-input/js/fileinput.min.js"></script>
    <script>
        const url = "{{url('/')}}"
        init_tinymce(url);
        // BUTTON ALONE
        init_btnImage(url,'#lfm');
        init_btnImage(url,'#lfm-meta');
        // SUBMIT FORM
        function submitForm(){
         $('form').submit();
        }

        $(document).ready(function(){
          // var footerTemplate = '<div class="file-thumbnail-footer" style ="height:94px">\n' +
          // '   <div style="margin:5px 0">\n' +
          // '       <input class="kv-input kv-new form-control input-sm text-center {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption..." name="caption[]">\n' +
          // '   </div>\n' +
          // '   {size} {progress} {actions}\n' +
          // '</div>';
            $("#thumb-input").fileinput({
                uploadUrl: "{{route('admin.product.store')}}", // server upload action
                uploadAsync: true,
                showUpload: false,
                showCaption: false,
                // layoutTemplates: {footer: footerTemplate},
                // previewThumbTags: {
                //     '{TAG_VALUE}': '',        // no value
                //     '{TAG_CSS_NEW}': '',      // new thumbnail input
                //     '{TAG_CSS_INIT}': 'hide'  // hide the initial input
                // },
                dropZoneEnabled : false,
                fileActionSettings:{
                  showUpload : false,
                }
            })

        })
    </script>
@stop
