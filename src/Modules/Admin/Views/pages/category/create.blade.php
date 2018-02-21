@extends('Admin::layouts.main-layout')

@section('link')
    <button class="btn btn-primary" onclick="submitForm();">Save</button>
@stop

@section('title','Create Category')

@section('content')
    <div class="row">
      <div class="col-sm-12">
        <form method="POST" action="{{route('admin.category.store')}}" id="form" role="form" class="form-horizontal">
          {{Form::token()}}
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
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
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
                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Save</button>
            </div>
        </form>
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
    </script>
@stop
