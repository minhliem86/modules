@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(url()->previous(), 'Cancel', ['class'=>'btn btn-danger'])}}
    <button class="btn btn-primary" onclick="submitForm();">Save Changes</button>
@stop

@section('title','Quản lý Sản Phẩm')

@section('content')
    <div class="row">
      <div class="col-sm-12">
        {{Form::model($inst, ['route'=>['admin.product.update',$inst->id], 'method'=>'put', 'files'=>true ])}}
          <div class="form-group">
            <label class="col-md-2 control-label">Sản phẩm</label>
            <div class="col-md-10">
              {{Form::text('title',old('title'), ['class'=>'form-control', 'placeholder'=>'Title'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Mô tả</label>
            <div class="col-md-10">
                <textarea required="" class="form-control my-editor" placeholder="Description" rows="15" id="description" name="description">
                    {!! old('description', $inst->description) !!}
                </textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Giá</label>
            <div class="col-md-10">
              {{Form::text('price',old('price'), ['class'=>'form-control', 'placeholder'=>'Price'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="description">Sắp xếp</label>
            <div class="col-md-10">
              {{Form::text('order',old('order'), ['class'=>'form-control', 'placeholder'=>'order'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="description">Trạng thái</label>
            <div class="col-md-10">
                <label class="toggle">
                  <input type="checkbox" name="status" value="1" {{$inst->status == 1 ? 'checked' : '' }}  >
                  <span class="handle"></span>
                </label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Hình ảnh:</label>
            <div class="col-md-10">
                <div class="input-group">
                 <span class="input-group-btn">
                   <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                     <i class="fa fa-picture-o"></i> Chọn
                   </a>
                 </span>
                 {{Form::hidden('avatar_img',old('avatar_img'), ['class'=>'form-control', 'id'=>'thumbnail' ])}}
                </div>
                <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset('public/upload/'.$inst->avatar_img)}}">
            </div>
          </div>
          <div class="form-group">
              <label class="col-md-2 control-label">Hình chi tiết </label>
              <div class="col-md-10">
                <div class="container-fluid">
                  @if($inst->photos->count())
                    @foreach($inst->photos()->get()->chunk(4) as $chunk )
                    <div class="row">
                      @foreach($chunk as $photo)
                      <div class="col-md-3">
                        <div class="file-preview-frame krajee-default  file-preview-initial file-sortable kv-preview-thumb" data-template="image">
                          <div class="kv-file-content">
                            <img src="{{asset('public/upload')}}/{{$photo->img_url}}" class="file-preview-image kv-preview-data img-responsive" title="" alt="" style="width:auto;height:120px;">
                          </div>
                          <div class="photo-order-input" style="margin-bottom:10px">
                            <input type="text" class="form-control text-center" name="photo_order" value="{{$photo->order}}">
                          </div>
                          <div class="file-footer-buttons">
                              <button type="button" class="kv-file-remove btn btn-xs btn-default" title="Cập nhật vị trí" onclick="updatePhoto(this,{{$photo->id}})"><i class="glyphicon glyphicon-refresh text-warning"></i></button>
                             <button type="button" class="kv-file-remove btn btn-xs btn-default" title="Remove file" onclick="removePhoto(this,{{$photo->id}})"><i class="glyphicon glyphicon-trash text-danger"></i></button>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                    @endforeach
                  @endif
                </div>
                <input type="file" name="thumb-input[]" id="thumb-input" multiple >
              </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Meta Keywords</label>
            <div class="col-md-10">
              {{Form::text('meta_keywords',old('meta_keywords'), ['class'=>'form-control', 'placeholder'=>'Keywords'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Meta Description</label>
            <div class="col-md-10">
              {{Form::text('meta_description',old('meta_description'), ['class'=>'form-control', 'placeholder'=>'Description'])}}
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Hình ảnh:</label>
            <div class="col-md-10">
                <div class="input-group">
                 <span class="input-group-btn">
                   <a id="lfm-meta" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                     <i class="fa fa-picture-o"></i> Chọn
                   </a>
                 </span>
                 {{Form::hidden('meta_image',old('meta_image'), ['class'=>'form-control', 'id'=>'thumbnail' ])}}
                </div>
                <img id="holder" style="margin-top:15px;max-height:100px;" src="{{asset('public/upload/'.$inst->meta_image)}}">
            </div>
          </div>
        </form>
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

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/bootstrap.min.css">
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.js"></script>

    <script>
      const url = "{{url('/')}}"
      init_tinymce(url);
      // BUTTON ALONE
      init_btnImage(url,'#lfm');
      // SUBMIT FORM
      function submitForm(){
       $('form').submit();
      }
      // $(document).ready(function(){
      //     $('radio[name="status"]').change(function(){
      //
      //     })
      // })
    </script>
    <script>
      $(document).ready(function(){
        $("#thumb-input").fileinput({
          uploadUrl: "{{route('admin.product.update',$inst->id)}}", // server upload action
          uploadAsync: true,
          showUpload: false,
          showCaption: false,
           browseLabel: "Thêm hình",
           dropZoneEnabled : false,
            fileActionSettings:{
              showUpload : false,
            }
        })
      })

      function removePhoto(e, id){
        $.ajax({
          url: '{{route("admin.product.AjaxRemovePhoto")}}',
          type: 'POST',
          data:{id_photo: id, _token:$('meta[name="csrf-token"]').attr('content')},
          success:function(data){
            if(!data.error){
              e.parentNode.parentNode.parentNode.remove();
            }
          }
        })
      }
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
@stop
