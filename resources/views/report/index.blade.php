@extends('master')
@section('title', 'Báo cáo')
@section('nav-report', 'active')
@section('style')
    <link rel="stylesheet" href="{{asset("/plugins/daterangepicker/daterangepicker.css")}}">
@endsection
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Báo cáo</h1>
                </div>
            </div>
        </div>
    </div>

    {{--------------------------------------Datatable-------------------------------------------------}}

    <div class="card">
        <div class="card-header">
            <label for="dateFilter">Chọn khoảng thời gian:</label>
            <div class="form-group ml-3" style="display: inline-block; width: 230px">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control float-right" id="dateFilter">
                </div>
            </div>

        </div>

        <div class="card-body">

            <table id="myDataTable"
                   class="table table-hover dataTable dtr-inline projects"
                   role="grid"
                   aria-describedby="example1_info" style="text-align: center">
                <thead>
                <tr role="row">
                    <th style="width:10px">#</th>
                    <th class="" style=""> Tên sản phẩm </th>
                    <th class="" style=""> Thuộc danh mục </th>
                    <th class="" style=""> Tổng số lượng </th>
                    <th class="" style=""> Tổng đã bán </th>
                    <th class="" style=""> Bán trong thời gian chọn </th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>


        </div>

    </div>

@endsection
@section('script')
    <script src="{{asset("/plugins/moment/moment.min.js")}}"></script>
    <script src="{{asset("/plugins/daterangepicker/daterangepicker.js")}}"></script>
    <script>
        $('#dateFilter').daterangepicker()

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

        var startDate = moment().startOf('month').format('YYYY-MM-DD')
        var endDate = moment().endOf('month').format('YYYY-MM-DD')
        $('#dateFilter').val(moment().startOf('month').format('DD-MM-YYYY') + ' - ' + moment().endOf('month').format('DD-MM-YYYY'))

        $(document).ready(function () {
            $('#myDataTable').DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": false,
                "serverSide": true, "ordering": false,
                "language": {
                    "url": "{{ asset('plugins/datatables/lang/vi.json') }}"
                },
                "ajax": {
                    "url": "{{ route('report.getDataTable') }}",
                    "data":function(d){
                        d.startDate = startDate;
                        d.endDate = endDate;
                    },
                },
                "columns": [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'catalog', name: 'catalog'},
                    {data: 'total', name: 'total'},
                    {data: 'sold', name: 'sold'},
                    {data: 'sold_in_filter', name: 'sold_in_filter'},
                ]
            });

            $('#dateFilter').on('apply.daterangepicker', function(ev, picker) {
                startDate = picker.startDate.format('YYYY-MM-DD')
                endDate = picker.endDate.format('YYYY-MM-DD')
                $('#myDataTable').DataTable().ajax.reload();
            });
        });
    </script>
@endsection
