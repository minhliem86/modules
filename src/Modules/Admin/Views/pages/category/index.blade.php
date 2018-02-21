@extends('Admin::layouts.main-layout')

@section('link')
    {{Html::link(route('admin.category.create'),'Add New',['class'=>'btn btn-primary'])}}
    <button type="button" class="btn btn-danger" id="btn-remove-all">Remove All Selected</button>
    <button type="button" class="btn btn-warning" id="btn-updateOrder">Update Order</button>
@stop

@section('title','Category Page')

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
        <div class="card">
            <div class="card-header">
                <strong>Company</strong>
                <small>Form</small>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Full</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <label class="switch switch-icon switch-success-outline">
                                <input type="checkbox" class="switch-input" checked="">
                                <span class="switch-label" data-on="" data-off=""></span>
                                <span class="switch-handle"></span>
                            </label>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-xs" class="button"><i class="fa fa-trash"></i></button>
                            <button class="btn btn-success btn-xs" class="button"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/bootflat-admin/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/scroll/jquery.mCustomScrollbar.min.js"></script>
    <!-- DATA TABLE -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/datatables/jquery.dataTables.min.css">
    <script src="{{asset('/public/assets/admin')}}/dist/js/plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.css">
    <link rel="stylesheet" href="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/bootstrap.min.css">
    <script type="text/javascript" src="{{asset('/public/assets/admin')}}/dist/js/plugins/alertify/alertify.js"></script>
    <script>
      $(document).ready(function(){
        hideAlert('.alert');
        // REMOVE ALL
        var table = $('table').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url:  '{!! route('admin.category.getData') !!}',
                data: function(d){
                    d.name = $('input[type="search"]').val();
                }
            },
            columns: [
               {data: 'id', name: 'id', 'orderable': false},
               {data: 'title', name: 'title'},
               {data: 'avatar_img', name: 'Avatar Photo', 'orderable': false},
               {data: 'order', name: 'order'},
               {data: 'status', name: 'status'},
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
                                'url':"{!!route('admin.category.deleteAll')!!}",
                                'data' : {arr: data,_token:$('meta[name="csrf-token"]').attr('content')},
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
                        url: '{{route("admin.category.postAjaxUpdateOrder")}}',
                        type:'POST',
                        data: {data: data_order,  _token:$('meta[name="csrf-token"]').attr('content') },
                        success: function(rs){
                            if(rs.code == 200){
                                location.reload(true);
                            }
                        }
                    })
                })

                $('input[name="status"]').change(function(){
                    let value = 0;
                    if($(this).is(':checked')){
                        value = 1;
                    }
                    const id_item = $(this).data('id');
                    console.log(id_item);
                    $.ajax({
                        url: "{{route('admin.category.updateStatus')}}",
                        type : 'POST',
                        data: {value: value, id: id_item, _token:$('meta[name="csrf-token"]').attr('content')},
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
