@extends('../master')
@section('nav-invoice')
    active
@endsection
@section('title')
    Tạo hóa đơn
@endsection
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection{
            height: 40px!important;
        }
    </style>
@endsection
@section('content')
    <div class="content-header">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Tạo hóa đơn</h1>
            </div>
        </div>
    </div>
    <div class="content px-2">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
{{--                    <p>Quét mã vạch</p>--}}
                    <input autofocus type="text" class="form-control" id="item_barcode" placeholder="Nhập hoặc quét mã hàng hóa">
                </div>
            </div>
            <div class="col-6">
                <select name="customer" id="customer" class="select2 w-100 h-100">
                    <option value="-1">Khách vãng lai</option>
                    @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <button class="btn btn-warning w-100" id="save_invoice">Bán (Không xuất hóa đơn)</button>
            </div>
            <div class="col-3">
                <button class="btn btn-primary w-100" id="create_invoice">Xuất hóa đơn</button>
            </div>
            <div class="col-12 mt-3">
{{--                <p>Số sản phẩm: <span id="total_product"></span></p>--}}
                <p>Số hàng hóa: <span id="total_item">0</span></p>
                <p>Tổng tiền: <span id="total_payment">0</span></p>
            </div>
            <div class="col-12 mt-3">
                <div class="row">
                    <div class="col-12 text-left">
                        <h5>Sản phẩm trong hóa đơn</h5>
                    </div>
                    <div class="col-12 text-left">
                        <button class="btn btn-danger fee-create">Tạo mục thu tiền</button>
                    </div>
                </div>
                <div class="info-box item-box" id="item_box_original" data-id="0" hidden>
                    <span class="info-box-icon bg-success"><i class="fa fa-database"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-bold item-title">Thốc CR-530</span>
                        <span class="info-box-text text-info item-barcode">Thốc CR-530</span>
                        <span class="info-box-text">Đơn giá:
                            <span class="item-price" data-price="0">0</span>
                        </span>
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <div>Số lượng </div>--}}
{{--                            <div>--}}
{{--                                <input type="number" class="form-control item-quantity ml-2" min="1" value="1">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="d-flex align-items-center text-red mr-3 item-remove" style="cursor: pointer">
                        <i class="fa fa-trash fa-2 pr-2"></i>Xóa
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-fee" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tạo mục thu<b></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <p class="text-info">Nhập mục thu tiền không có trong kho hàng.</p>
                            <label for="exampleInputEmail1">Tên mục thu</label>
                            <input type="text" name="name" class="form-control fee-name" placeholder="Tên mục thu tiền">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá</label>
                            <input type="number" name="price" class="form-control fee-price" placeholder="Giá">
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" disabled style="display: none" aria-hidden="true"></button>
                            <button type="button" class="btn btn-success btn-fee-submit">Thêm mục thu tiền</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#customer').select2({
                width: '100%',
                height: '100%'
            });

            function calcuateSumary()
            {
                let itemCount = $('.item-box:not(#item_box_original)').length;
                let totalPayment = $('.item-box:not(#item_box_original)').map(function () {
                    return parseInt($(this).find('.item-price').attr('data-price'));
                }).get().reduce(function (a, b) {
                    return a + b;
                }, 0);
                $('#total_item').text(itemCount);
                $('#total_payment').text(totalPayment.toLocaleString() + 'VNĐ');
            }

            function createItem(id, catalogName, productName, price, barcode)
            {
                //clone and append item-box
                let item_box = $('#item_box_original').clone();
                item_box.removeAttr('id');
                item_box.removeAttr('hidden');
                item_box.find('.item-title').text(productName);
                item_box.find('.item-price').text(price.toLocaleString() + 'VNĐ');
                item_box.find('.item-price').attr('data-price', price);
                item_box.find('.item-barcode').text(barcode);
                item_box.attr('data-id', id);
                item_box.find('.item-quantity').text(1);
                //append item_box after item_box_original
                $('#item_box_original').after(item_box);
                calcuateSumary();
            }

            //on remove item clicked
            $(document).on('click', '.item-remove', function () {
                $(this).closest('.item-box').remove();
                calcuateSumary();
            });

            //on press enter item_barcode
            $('#item_barcode').keypress(function (e) {
                if (e.which == 13) {
                    let barcode = $(this).val();
                    //clear input
                    $(this).val('');
                    //if barcode available, cancel ajax request
                    let item_box = $('.item-box');
                    let item_box_available = false;
                    item_box.each(function () {
                        if ($(this).find('.item-barcode').text() == barcode) {
                            item_box_available = true;
                            toastr.error('Mã hàng hóa đã tồn tại trong hóa đơn', 'Lỗi', {timeOut: 1000});
                        }
                    });
                    //get item by barcode
                    if(!item_box_available){
                        $('#loading_spinner').attr('hidden', false);
                        $.ajax({
                            url: '{{route('item-detail')}}',
                            type: 'GET',
                            data: {
                                barcode: barcode
                            },
                            success: function (data) {
                                data = JSON.parse(data);
                                console.log(data);
                                if(data.status == 'Sold')
                                {
                                    toastr.error('Mã hàng hóa đã được bán', 'Lỗi', {timeOut: 1000});
                                }
                                else if(data.status == false)
                                {
                                    toastr.error('Mã hàng hóa không tồn tại', 'Lỗi', {timeOut: 1000});
                                }
                                else{
                                    createItem(data.id, data.product.catalog.name, data.product.name, data.product.price, data.barcode);
                                }
                                $('#loading_spinner').attr('hidden', 'hidden');
                            }
                        });
                    }
                }
            });

            $('#create_invoice').on('click', function(){
                $(this).attr('disabled', true);
                save_invoice(true);
            });

            $('#save_invoice').on('click', function(){
                $(this).attr('disabled', true);
                save_invoice(false);
            });

            function save_invoice(printInvoice)
            {
                let items = [];
                //get item-box except #item_box_original
                $('.item-box:not(#item_box_original)').each(function(){
                    let item = {
                        id: $(this).attr('data-id'),
                        price: $(this).find('.item-price').attr('data-price'),
                        name: $(this).find('.item-title').text(),
                    };
                    items.push(item);
                });
                //get items length
                if(items.length === 0)
                {
                    toastr.error('Hóa đơn không có sản phẩm nào', 'Lỗi', {timeOut: 1000});
                    $('#create_invoice').attr('disabled', false);
                    $('#save_invoice').attr('disabled', false);
                    return;
                }
                $('#loading_spinner').attr('hidden', false);
                $.ajax({
                    url: '{{route('invoice-create')}}',
                    type: 'POST',
                    data: {
                        customer: $('#customer').val(),
                        items: items
                    },
                    success: function (data) {
                        $('#loading_spinner').attr('hidden', 'hidden');
                        data = JSON.parse(data);
                        if(data.status == 'success'){
                            toastr.success('Tạo hóa đơn thành công', 'Thành công', {timeOut: 1000});
                            if(printInvoice == true)
                            {
                                $("<iframe>")                             // create a new iframe element
                                    .hide()                               // make it invisible
                                    .attr("src", '{{route('invoice-export')}}?id=' + data.id) // point the iframe to the page you want to print
                                    .appendTo("body");
                                setTimeout(function(){
                                    window.location.reload();
                                }, 1000);
                            }
                            else{
                                setTimeout(function(){
                                    window.location.reload();
                                }, 1000);
                            }
                        }
                    }
                });
            }

            //Tao5 danh mục thu tiền
            $('.fee-create').on('click', function(){
                $('#modal-fee').modal('show');
            })
            $('.btn-fee-submit').on('click', function(){
                let fee_name = $('.fee-name').val();
                let fee_price = $('.fee-price').val();
                if(fee_name == '' || fee_price == '')
                {
                    toastr.error('Vui lòng nhập đầy đủ thông tin', 'Lỗi', {timeOut: 1000});
                    return;
                }
                let item_box = $('#item_box_original').clone();
                item_box.removeAttr('id');
                item_box.removeAttr('hidden');
                item_box.find('.item-title').text(fee_name);
                item_box.find('.item-price').text(parseInt(fee_price).toLocaleString() + 'VNĐ');
                item_box.find('.item-price').attr('data-price', parseInt(fee_price));
                item_box.find('.item-barcode').text('');
                item_box.attr('data-id', '0');
                // item_box.find('.item-quantity').text(1);
                //append item_box after item_box_original
                $('#item_box_original').after(item_box);
                calcuateSumary();
            })
        });
    </script>
@endsection
