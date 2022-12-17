@extends('../master')
@section('nav-invoice-list')
    active
@endsection
@section('title')
    Danh sách hóa đơn
@endsection
@section('content')
    <div class="content-header">
        <div class="row">
            <div class="col-6">
                <h1>Danh sách hóa đơn</h1>
            </div>
        </div>
    </div>
    <div class="content px-2">
        <table class="display datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Ngày tạo</th>
                <th>Khách hàng</th>
                <th>Người tạo</th>
                <th>Lượng hàng hóa</th>
                <th>Số tền</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{$invoice->created_at}}</td>
                        <td>
                            @if($invoice->customer_id)
                                {{$invoice->customer->name}}
                            @else
                                Khách vãng lai
                            @endif
                        </td>
                        <td>{{$invoice->user->name}}</td>
                        <td>{{$invoice->InvoiceDetail->count()}}</td>
                        <td>{{number_format($invoice->getTotalPayment())}}VNĐ</td>
                        <td>
                            <a class="btn btn-success" href="{{route('invoice-export', ['id'=>$invoice->id])}}" target="_blank">Xuất hóa đơn</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
                order: [[0, 'desc']],
            });
        });
        $('#btn_add_product').on('click', function(){
            $('#modal-product').modal('show');
        });
        $('.btn-delete').on('click', function(){
            Swal.fire({
                title: 'Xóa danh mục sẽ xóa toàn bộ sản phẩm?',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{route('product-delete')}}?id=" + $(this).data('id');
                }
            })
        });
    </script>
@endsection
