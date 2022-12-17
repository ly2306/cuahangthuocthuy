<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request){
//        $product = Product::find(3);
//
//        $from = date('2022-11-01');
//        $to = date('2022-11-28');
//        dd($product->InvoiceDetail->whereBetween('created_at', [$from, $to])->count());



        return view('report.index');
    }

    public function getDataTable(Request $request){
//        dd($request->startDate);
        $date_from = $request->startDate;
        $date_to = $request->endDate;

        $products = Product::all()->sortBy('catalog_id');
        return datatables()->of($products)
            ->addIndexColumn()
            ->addColumn('catalog', function ($row) {
                return $row->Catalog->name;
            })->addColumn('total', function ($row) {
                return $row->Item->count();
            })->addColumn('sold', function ($row) {
                return $row->InvoiceDetail->count();
            })->addColumn('sold_in_filter', function ($row) use ($date_from, $date_to) {
                return $row->InvoiceDetail->whereBetween('created_at', [$date_from, $date_to])->count();
            })->rawColumns([])
            ->toJson();
    }
}
