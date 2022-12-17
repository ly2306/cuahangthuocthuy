<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    #Lấy user giả, do chưa có auth
    private $user;

    public function __construct()
    {
        $this->user = User::find(1);
    }

    public function index()
    {
        $cutomers = Customer::all();
        return view('invoice.index')->with([
            'customers'=>$cutomers
        ]);
    }

    public function itemDetail(Request $request)
    {
        //Sản phẩm không tồn tại thì báo lô
        try{
            $item = Item::where('barcode', $request->barcode)->firstOrFail();
        }
        catch(\Exception $e){
            return json_encode([
                'status'=>false,
                'message'=>'Sản phẩm không tồn tại'
            ]);
        }

        $product = $item->product;
        $catalog = $product->catalog;
        //Kiểm tra xem món hàng này được bán chưa
        if($item->InvoiceDetail->count() > 0)
        {
            $item->status = "Sold";
        }
        $jsonResult = $item->toJson();
        return $jsonResult;
    }

    public function create(Request $request)
    {
        $invoice = new Invoice();
        if($request->customer != -1)
        {
            $invoice->customer_id = $request->customer;
        }
        else{
            $invoice->isPasserby = 1;
        }
        $invoice->user_id = $this->user->id;
        $invoice->save();
        foreach($request->items as $item)
        {
            if($item['id'] ==0 )
            {
                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->invoice_id = $invoice->id;
                $invoiceDetail->invoice_price = $item['price'];
                $invoiceDetail->name = $item['name'];
                $invoiceDetail->save();
            }
            else{
                $itemDetail = Item::find($item['id']);
                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->invoice_id = $invoice->id;
                $invoiceDetail->item_id = $itemDetail->id;
                $invoiceDetail->invoice_price = $itemDetail->Product->price;
                $invoiceDetail->save();
            }
        }
        return json_encode([
            'id' => $invoice->id,
            'status' => 'success',
            'message' => 'Tạo hóa đơn thành công'
        ]);
    }

    public function list()
    {
        $invoices = Invoice::all();
        return view('invoice.list')->with([
            'invoices'=>$invoices
        ]);
    }

    public function export(Request $request)
    {
        $invoice = Invoice::find($request->id);
        return view('invoice.invoiceExport')->with([
            'invoice'=>$invoice
        ]);
    }
}
