@extends('Admin::layouts.default')

@section('title','Thư Viện Ảnh')

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <p>{{Session::get('error')}}</p>
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <p>{{Session::get('success')}}</p>
        </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="wrap-center">
                            <a href="{!! route('admin.album.create') !!}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Thêm</a>
                            <button type="button" class="btn btn-warning btn-sm text-white" id="btn-updateOrder"><i class="fa fa-refresh"></i> Cập Nhật Thứ Tự</button>
                        </div>
                        <div class="wrap-title">
                            <strong>Thư Viện Ảnh</strong>
                        </div>
                        <div class="wrap-control">
                            <button type="button" class="btn btn-danger btn-sm" id="btn-remove-all"><i class="fa fa-trash"></i> Xóa Chọn</button>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm  table-striped table-sm">

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/js/bootstrap.min.js"></script>
    <!-- DATA TABLE -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/js/plugins/datatables/jquery.dataTables.min.css">
    <script src="{{asset('/public/assets/admin')}}/js/plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/js/plugins/alertify/alertify.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/js/plugins/alertify/bootstrap.min.css">
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/js/plugins/alertify/alertify.js"></script>

    <script>
        $(document).ready(function(){
            hideAlert('.alert');
            // REMOVE ALL
            var table = $('table').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url:  '{!! route('admin.album.index') !!}',
                    data: function(d){
                        d.name = $('input[type="search"]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id', 'orderable': false, title: '#', visible: false},
                    {data: 'title', name: 'Album', title: 'Album'},
                    {data: 'img_url', name: 'Hình ảnh', title: 'Hình Ảnh', 'orderable': false},
                    {data: 'order', name: 'Sắp xếp', title: 'Sắp xếp'},
                    {data: 'status', name: 'Trạng thái', title: 'Trạng Thái'},
                    {data: 'action', name: 'action', 'orderable': false}
                ],
                initComplete: function(){
                    var table_api = this.api();
                    var data = [];
                    var data_order = {};
                    $('#btn-remove-all').click( function () {
                        var rows = table_api.rows('.selected').data();
                        rows.each(function(index, e){
                            data.push(index.id);
                        })
                        alertify.confirm('You can not undo this action. Are you sure ?', function(e){
                            if(e){
                                $.ajax({
                                    'url':"{!!route('admin.album.deleteAll')!!}",
                                    'data' : {arr: data},
                                    'type': "POST",
                                    'success':function(result){
                                        if(result.msg = 'ok'){
                                            table.rows('.selected').remove();
                                            table.draw();
                                            alertify.success('The data is removed!');
                                            location.reload();
                                        }
                                    }
                                });
                            }
                        })
                    })

                    $('#btn-updateOrder').click(function(){
                        var rows_order = table_api.rows().data();
                        var data_order = {};
                        $('input[name="order"]').each(function(index){
                            var id = $(this).data('id');
                            var va = $(this).val();
                            data_order[id] = va;
                        });
                        $.ajax({
                            url: '{{route("admin.album.postAjaxUpdateOrder")}}',
                            type:'POST',
                            data: {data: data_order },
                            success: function(rs){
                                if(rs.code == 200){
                                    location.reload(true);
                                }
                            }
                        })
                    })
                    $('table.table').on('change','input[name=status]', function(){
                        var value = 0;
                        if($(this).is(':checked')){
                            value = 1;
                        }
                        const id_item = $(this).data('id');
                        console.log(id_item);
                        $.ajax({
                            url: "{{route('admin.album.updateStatus')}}",
                            type : 'POST',
                            data: {value: value, id: id_item},
                            success: function(data){
                                if(!data.error){
                                    alertify.success('Status changed !');
                                }else{
                                    alertify.error('Fail changed !');
                                }
                            }
                        })
                    })
                }
            });
            /*SELECT ROW*/
            $('table tbody').on('click','tr',function(){
                $(this).toggleClass('selected');
            })

        });
        function confirm_remove(a){
            alertify.confirm('You can not undo this action. Are you sure ?', function(e){
                if(e){
                    a.parentElement.submit();
                }
            });
        }

        function hideAlert(a){
            setTimeout(function(){
                $(a).fadeOut();
            },2000)
        }
    </script>
@stop
