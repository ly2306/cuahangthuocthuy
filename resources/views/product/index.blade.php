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
                <h1>Quản lý kho</h1>
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-success" id="btn_add_product">Thêm sản phẩm</button>
            </div>
        </div>
    </div>
    <div class="content px-2">
        <table class="display datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Ngày tạo</th>
                <th>Số lượng trong kho</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->catalog->name}}</td>
                    <td>{{$product->created_at}}</td>
                    <td>{{$product->item->count()}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{route('product-show', ['product_id'=>$product->id])}}">Xem thêm</a>
                        <button class="btn btn-danger ml-2 btn-edit" data-id="{{$product->id}}" data-json="{{$product->toJson()}}">Sửa</button>
                        <button class="btn btn-danger ml-2 btn-delete" data-id="{{$product->id}}">Xóa</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="modal-product" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm sản phẩm</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('product-create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá</label>
                            <input type="number" min="0" name="product_price" class="form-control" placeholder="Nhập giá" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Danh mục</label>
                            <select class="form-control" name="catalog" required>
                                @foreach($catalogs as $catalog)
                                    <option value="{{$catalog->id}}">{{$catalog->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group text-right">
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
        $('.btn-edit').on('click', function(){
            $('#modal-product').find('.modal-title').text('Sửa sản phẩm');
            $('#modal-product').find('form').attr('action', "{{route('product-edit')}}");
            $('#modal-product').find('form').append('<input type="hidden" name="product_id" value="'+$(this).data('id')+'">');
            let jsonData = $(this).data('json');
            $('#modal-product').find('input[name="product_name"]').val(jsonData.name);
            $('#modal-product').find('input[name="product_price"]').val(jsonData.price);
            $('#modal-product').find('select[name="catalog"]').val(jsonData.catalog_id);
            $('#modal-product').modal('show');
        })
        //on hide modal
        $('#modal-product').on('hidden.bs.modal', function (e) {
            $('#modal-product').find('.modal-title').text('Thêm sản phẩm');
            $('#modal-product').find('form').attr('action', "{{route('product-create')}}");
            $('#modal-product').find('form').find('input[name="product_id"]').remove();
            $('#modal-product').find('input[name="product_name"]').val('');
            $('#modal-product').find('input[name="product_price"]').val('');
            $('#modal-product').find('select[name="catalog"]').val('');
        })
    </script>
@endsection
