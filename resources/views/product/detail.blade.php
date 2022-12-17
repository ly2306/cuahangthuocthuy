@extends('../master')
@section('nav-products')
    active
@endsection
@section('title')
    Quản lý kho
@endsection
@section('content')
    <div class="content-header">
        <div class="row">
            <div class="col-6">
                <h1>Quản lý hàng hóa</h1>
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-success" id="btn_add_item">Thêm hàng hóa</button>
            </div>
        </div>
    </div>
    <div class="content px-2">
        <table class="display datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <td>Danh mục</td>
                <td>Mã vạch</td>
                <td>Trạng thái</td>
                <td>Ngày thêm</td>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$item->barcode}}</td>
                    @if($item->invoice->count() > 0)
                        <td>
                            <span class="badge badge-primary">Đã bán</span>
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td></td>
                    @else
                        <td>
                            <span class="badge badge-dark">Chưa bán</span>
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <button class="btn btn-danger ml-2 btn-delete" data-id="{{$item->id}}">Xóa</button>
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="modal-item" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm hàng hóa vào sản phẩm <b>{{$product->name}}</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('product-item-create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <p class="text-info">Quét mã vạch vào từng hàng hóa để thêm vào.</p>
                            <p class="text-info">Nếu dùng bàn phím gõ mã hàng và nhấn Enter để xuống dòng.</p>
                            <label for="exampleInputEmail1">Mã vạch</label>
                            <input type="text" name="barcode[]" class="form-control barcode-input" placeholder="Quét mã vạch">
                        </div>
                        <input type="text" name="product_id" value="{{$product->id}}" hidden>
                        <div class="form-group text-right">
                            <button type="submit" disabled style="display: none" aria-hidden="true"></button>
                            <button class="btn btn-success">Thêm sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.datatable').DataTable();
        });
        $('#btn_add_item').on('click', function(){
            $('#modal-item').modal('show');
        });

        //barcode-input clone when press enter
        $(document).on('keypress', '.barcode-input', function(e){
            if(e.which == 13){
                var clone = $(this).clone();
                $(this).after(clone);
                $(this).val('');
            }
        });

        $('.btn-delete').on('click', function(){
            Swal.fire({
                title: 'Xóa hàng hóa?',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{route('product-item-delete')}}?id=" + $(this).data('id');
                }
            })
        });
    </script>
@endsection
