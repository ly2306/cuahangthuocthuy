<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.index');
    }

    public function getDataTable(){
        $customers = Customer::all();
        return datatables()->of($customers)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $json_data = json_encode($row);

                $html = '<div class="btn btn-outline-secondary btn-sm btnEdit" data = \''.$json_data.'\'><i class="fa-solid fa-pencil"></i> Cập nhật </div>';
                $html .= '<div class="btn btn-outline-danger btn-sm btnDelete ml-2" data="'.$row->id.'"><i class="fa-solid fa-trash"></i> Xóa </div>';
                return $html;
            })->rawColumns(['action'])
            ->toJson();
    }

    public function store(Request $request){
        try {
            $customer = new Customer();
            $customer->name = $request->nameCustomer;
            $customer->phone = $request->phoneCustomer;
            $customer->save();
            return redirect()->back()->with('success', 'Thêm mới thành công');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id){
        try {
            $customer = Customer::find($id);
            $customer->name = $request->nameCustomer;
            $customer->phone = $request->phoneCustomer;
            $customer->save();
            return redirect()->back()->with('success', 'Cập nhật thành công');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(Request $request){
        try {
            $customer = Customer::find($request->id);
            $customer->delete();
            return response()->json(['status' => 200, 'message' => 'Xóa thành công']);
        }catch (\Exception $e){
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
