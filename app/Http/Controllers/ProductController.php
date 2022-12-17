<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $catalogs = Catalog::all();
        return view('product.index')->with([
            'products'=>$products,
            'catalogs'=>$catalogs
        ]);
    }

    public function create(Request $request)
    {
        $product = new Product();
        $product->name = $request->product_name;
        $product->price = $request->product_price;
        $product->catalog_id = $request->catalog;
        $product->save();
        return redirect()->back()->with('success', 'Thêm sản phẩm thành công');
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        try{
            $product->delete();
            return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Không thể xóa sản phẩm đã được bán');
        }
        
    }

    //Quản lý các item của product
    public function detail($product_id)
    {
        $items = Product::find($product_id)->item;
        $product = Product::find($product_id);
        return view('product.detail')->with([
            'items'=>$items,
            'product'=>$product
        ]);
    }

    public function deleteItem(Request $request)
    {
        $item = Item::find($request->id);
        $item->delete();
        return redirect()->back()->with('success', 'Xóa hàng hóa thành công');
    }

    public function createItem(Request $request)
    {
        $item_count = 0;
        foreach($request->barcode as $barcode)
        {
            if(empty($barcode))
            {
                continue;
            }
            $item = new Item();
            $item->barcode = $barcode;
            $item->product_id = $request->product_id;
            $item->save();
            $item_count++;
        }
        return redirect()->back()->with('success', 'Thêm thành công ' . $item_count . ' hàng hóa');
    }

    public function edit(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->name = $request->product_name;
        $product->price = $request->product_price;
        $product->catalog_id = $request->catalog;
        $product->save();
        return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công');
    }
}
