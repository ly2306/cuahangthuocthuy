@extends('master')
@section('title', 'Tài khoản')
@section('nav-user', 'active')
@section('style')

@endsection
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý Tài khoản</h1>
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
                    <th class="" style=""> Tên tài khoản
                    </th>
                    <th class="" style=""> Email
                    </th>
                    <th class="" style=""> Loại tài khoản
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
                    <h4 class="modal-title">Thông tin Tài khoản</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="form-group">
                            <label for="">Họ tên</label>
                            <input type="text" class="form-control nameUser" name="nameUser" value="{{ old('nameUser') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control emailUser" name="emailUser" value="{{ old('emailUser') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Mật khẩu</label>
                            <span class="text-info text-sm" id="txtAlert">Bỏ trống nếu không muốn thay đổi</span>
                            <input type="password" class="form-control passwordUser" name="passwordUser" value="{{ old('passwordUser') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Loại tài khoản</label>
                            <select name="roleUser" id="roleUser" class="form-control roleUser">
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
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
                "ajax": '{{ route('user.getDataTable') }}',
                "columns": [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'role', name: 'role'},
                    {data: 'action', name: 'action'},
                ]
            });


            $(document).on('click', '.btnAdd', function () {
                $('#myForm').attr('action', '{{ route('user.store') }}');
                $('.nameUser').val('');
                $('.emailUser').val('');
                $('.passwordUser').val('');
                $('.roleUser').val(1);
                $('#txtAlert').hide();

                $('#myModal').modal('show');
            });

            $(document).on('click', '.btnEdit', function () {
                var data = JSON.parse($(this).attr('data'));
                $('#myForm').attr('action', '{{ route('user.update') }}' + '/' + data.id);
                $('.nameUser').val(data.name);
                $('.emailUser').val(data.email);
                $('.passwordUser').val('');
                $('#txtAlert').show();

                var role = $(this).data('role');
                $('.roleUser').val(role);

                $('#myModal').modal('show');
            });

            $(document).on('click', '.btnSave', function () {
                if ($('.nameUser').val() == '' || $('.emailUser').val() == '' || ($('.passwordUser').val() == '' && $('#myForm').attr('action') == '{{ route('user.store') }}')) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Vui lòng nhập đầy đủ thông tin'
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
                            url: '{{ route('user.delete') }}',
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
