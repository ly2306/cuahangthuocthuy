<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        return view('catalog.index');
    }

    public function getDataTable(){
        $catalogs = Catalog::all();
        return datatables()->of($catalogs)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
//                $data = User::find($row->id)->toArray();
                $json_data = json_encode($row);

                $html = '<div class="btn btn-outline-secondary btn-sm btnEdit" data = \''.$json_data.'\'><i class="fa-solid fa-pencil"></i> Cập nhật </div>';
                $html .= '<div class="btn btn-outline-danger btn-sm btnDelete ml-2" data="'.$row->id.'"><i class="fa-solid fa-trash"></i> Xóa </div>';
                return $html;
            })->rawColumns(['action'])
            ->toJson();
    }

    public function store(Request $request){
        try {
            $catalog = new Catalog();
            $catalog->name = $request->nameCatalog;
            $catalog->save();
            return redirect()->back()->with('success', 'Thêm mới thành công');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id){
        try {
            $catalog = Catalog::find($id);
            $catalog->name = $request->nameCatalog;
            $catalog->save();
            return redirect()->back()->with('success', 'Cập nhật thành công');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(Request $request){
        try {
            $catalog = Catalog::find($request->id);
            $catalog->delete();
            return response()->json(['status' => 200, 'message' => 'Xóa thành công']);
        }catch (\Exception $e){
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
