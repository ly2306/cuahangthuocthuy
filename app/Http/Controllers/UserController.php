<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function getDataTable(){
        $users = User::all();
        return datatables()->of($users)
            ->addIndexColumn()
            ->addColumn('role', function ($row) {
                if ($row->hasRole('admin')) {
                    return '<span class="badge badge-primary">Admin</span>';
                } else {
                    return '<span class="badge badge-secondary">User</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $json_data = json_encode($row);

                if ($row->hasRole('admin')) {
                    $role = 1;
                } else {
                    $role = 2;
                }

                $html = '<div class="btn btn-outline-secondary btn-sm btnEdit" data = \''.$json_data.'\' data-role = \''.$role.'\'><i class="fa-solid fa-pencil"></i> Cập nhật </div>';
                $html .= '<div class="btn btn-outline-danger btn-sm btnDelete ml-2" data="'.$row->id.'"><i class="fa-solid fa-trash"></i> Xóa </div>';
                return $html;
            })->rawColumns(['action', 'role'])
            ->toJson();
    }

    public function store(Request $request){
        try {
            $user = new User();
            $user->name = $request->nameUser;
            $user->email = $request->emailUser;
            $user->password = bcrypt($request->passwordUser);
            $user->save();

            $user->roles()->attach($request->roleUser);

            return redirect()->back()->with('success', 'Thêm mới thành công');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id){
        try {
            $user = User::find($id);
            $user->name = $request->nameUser;
            $user->email = $request->emailUser;
            if ($request->passwordUser){
                $user->password = bcrypt($request->passwordUser);
            }
            $user->save();

            $user->roles()->sync($request->roleUser);

            return redirect()->back()->with('success', 'Cập nhật thành công');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(Request $request){
        try {
            $user = User::find($request->id);
            $user->delete();

            return response()->json(['status' => 200, 'message' => 'Xóa thành công']);
        }catch (\Exception $e){
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
