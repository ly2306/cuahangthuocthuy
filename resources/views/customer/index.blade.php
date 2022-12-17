@extends('master')
@section('title', 'Khách hàng')
@section('nav-customer', 'active')
@section('style')

@endsection
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý Khách hàng</h1>
                </div>
            </div>
        </div>
    </div>

    {{--------------------------------------Datatable-------------------------------------------------}}

    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-success btnAdd">Thêm</button>
        </div>

        <div class="card-body">

            <table id="myDataTable"
                   class="table table-hover dataTable dtr-inline projects"
                   role="grid"
                   aria-describedby="example1_info" style="text-align: center">
                <thead>
                <tr role="row">
                    <th style="width:10px">#</th>
                    <th class="" style=""> Tên khách hàng
                    </th>
                    <th class="" style=""> Số điện thoại
                    </th>
                    <th style="width:160px">
                    </th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>


        </div>

    </div>

    {{---------------------------------------Modal----------------------------------------------------}}

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin Khách hàng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="form-group">
                            <label for="">Tên khách hàng</label>
                            <input type="text" class="form-control nameCustomer" name="nameCustomer" value="{{ old('nameCustomer') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Số điện thoại</label>
                            <input type="text" class="form-control phoneCustomer" name="phoneCustomer" value="{{ old('phoneCustomer') }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary btnSave">Lưu</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $(document).ready(function () {

            $('#myDataTable').DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": false,
                "serverSide": true, "ordering": false,
                "language": {
                    "url": "{{ asset('plugins/datatables/lang/vi.json') }}"
                },
                "ajax": '{{ route('customer.getDataTable') }}',
                "columns": [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'action', name: 'action'},
                ]
            });


            $(document).on('click', '.btnAdd', function () {
                $('#myModal').modal('show');
                $('#myForm').attr('action', '{{ route('customer.store') }}');
                $('.nameCustomer').val('');
                $('.phoneCustomer').val('');
            });

            $(document).on('click', '.btnEdit', function () {
                var data = JSON.parse($(this).attr('data'));
                $('#myForm').attr('action', '{{ route('customer.update') }}' + '/' + data.id);
                $('.nameCustomer').val(data.name);
                $('.phoneCustomer').val(data.phone);

                $('#myModal').modal('show');
            });

            $(document).on('click', '.btnSave', function () {
                if ($('.nameCustomer').val() == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Vui lòng nhập tên khách hàng'
                    })
                    return;
                }
                if($('.phoneCustomer').val() == '' || $('.phoneCustomer').val().length != 10){
                    Toast.fire({
                        icon: 'warning',
                        title: 'Số điện thoại không hợp lệ'
                    })
                    return;
                }
                $('#myForm').submit();
            });

            $(document).on('click','.btnDelete', function () {
                Swal.fire({
                    title: 'Chắc chắn xóa?',
                    text: "Sau khi xóa dữ liệu sẽ không thể khôi phục",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).attr('data')
                        $.ajax({
                            url: '{{ route('customer.delete') }}',
                            type: "DELETE",
                            data: {
                                'id': id,
                            },
                            success: function (result) {
                                if (result.status === 200) {
                                    $('#myDataTable').DataTable().ajax.reload();
                                    Swal.fire(
                                        'Thành công!',
                                        result.message,
                                        'success'
                                    )
                                } else {
                                    Swal.fire(
                                        'Thất bại!',
                                        result.message,
                                        'error'
                                    )
                                }
                            }
                        });
                    }
                })
            })


        });
    </script>
@endsection
