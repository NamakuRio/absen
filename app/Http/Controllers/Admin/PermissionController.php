<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        return view('admin.permission');
    }

    public function store(Request $request)
    {
        if($this->checkPermission('permission.create')) abort(404);

        DB::beginTransaction();
        try{
            $validator = $this->validator($request->all());

            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $data = [
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ];

            $insert = Permission::create($data);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($insert) return response()->json(['status' => 'success', 'msg' => 'Berhasil menambahkan izin']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal menambahkan izin']);
    }

    public function edit(Request $request)
    {
        if($this->checkPermission('permission.update')) abort(404);

        $permission = Permission::find($request->id);

        return response()->json(['status' => 'success', 'data' => $permission]);
    }

    public function update(Request $request)
    {
        if($this->checkPermission('permission.update')) abort(404);

        DB::beginTransaction();
        try{
            $validator = $this->validator($request->all(), 'update');

            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $permission = Permission::find($request->id);

            $name = $permission->name;
            $guard_name = $request->guard_name;

            if($name != $request->name){
                $check_name = Permission::where('name', '=', $request->name)->get()->count();

                if($check_name != 0){
                    return response()->json(['status' => 'warning', 'msg' => 'Nama yang Anda masukkan sudah terdaftar']);
                }

                $name = $request->name;
            }

            $data = [
                'name' => $name,
                'guard_name' => $guard_name,
            ];

            $update = $permission->update($data);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($update) return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah izin']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal mengubah izin']);
    }

    public function destroy(Request $request)
    {
        if($this->checkPermission('permission.delete')) abort(404);

        $destroy = Permission::destroy($request->id);

        if($destroy) return response()->json(['status' => 'success', 'msg' => 'Berhasil menghapus izin']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal menghapus izin']);
    }

    public function data()
    {
        if($this->checkPermission('permission.view')) abort(404);

        $permissions = Permission::all();

        return DataTables::of($permissions)
                    ->addColumn('action', function($permission) {
                        $action = "";

                        if(auth()->user()->can('permission.update')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' tooltip='Memperbarui Izin' data-id='{$permission->id}' onclick='getUpdatePermission(this);'><i class='far fa-edit'></i></a>&nbsp;";
                        if(auth()->user()->can('permission.delete')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger' tooltip='Menghapus Izin' data-id='{$permission->id}' onclick='deletePermission(this);'><i class='fas fa-trash'></i></a>&nbsp;";

                        return $action;
                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }

    protected function validator(array $data, $type = 'insert')
    {
        $name = 'unique:permissions,name';

        if($type == 'update'){
            $name = '';
        }

        $message = [
            'required' => ':attribute tidak boleh kosong',
            'string' => ':attribute harus bertipe String',
            'max' => ':attribute maksimal :max karakter',
            'unique' => ':attribute sudah terdaftar',
        ];

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191', $name],
            'guard_name' => ['required', 'max:191'],
        ], $message);
    }

    protected function checkPermission($permission)
    {
        return (bool) (!auth()->user()->can($permission));
    }
}
