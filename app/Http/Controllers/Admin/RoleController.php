<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role');
    }

    public function store(Request $request)
    {
        if($this->checkPermission('role.create')) abort(404);

        DB::beginTransaction();
        try{
            $validator = $this->validator($request->all());

            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $data = [
                'name' => $request->name,
                'login_destination' => $request->login_destination,
            ];

            $insert = Role::create($data);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($insert) return response()->json(['status' => 'success', 'msg' => 'Berhasil menambahkan peran']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal menambahkan peran']);
    }

    public function edit(Request $request)
    {
        if($this->checkPermission('role.update')) abort(404);

        $role = Role::find($request->id);

        return response()->json(['status' => 'success', 'data' => $role]);
    }

    public function update(Request $request)
    {
        if($this->checkPermission('role.update')) abort(404);

        DB::beginTransaction();
        try{
            $validator = $this->validator($request->all(), 'update');

            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $role = Role::find($request->id);

            $name = $role->name;
            $login_destination = $request->login_destination;

            if($name != $request->name){
                $check_name = Role::where('name', '=', $request->name)->get()->count();

                if($check_name != 0){
                    return response()->json(['status' => 'warning', 'msg' => 'Nama yang Anda masukkan sudah terdaftar']);
                }

                $name = $request->name;
            }

            $data = [
                'name' => $name,
                'login_destination' => $login_destination,
            ];

            $update = $role->update($data);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($update) return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah peran']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal mengubah peran']);
    }

    public function getManage(Request $request)
    {
        if($this->checkPermission('role.manage')) abort(404);

        $permissions = Permission::all();
        $role = Role::find($request->id);
        $view = "";

        $view .= '<input type="hidden" id="manage-role-id" name="id" value="'.$role->id.'" required>';

        $view .= '<div class="row">';
        $view .= '<div class="col-12 text-center">';
        $view .= '<h4>User '.ucfirst($role->name).'</h4>';
        $view .= '</div>';

        foreach($permissions as $permission){
            $checked = '';

            foreach($permission->roles as $role_permission){
                if($role->id == $role_permission->id){
                    $checked = 'checked';
                }
            }

            $view .= '<div class="form-group col-lg-6" style="margin:0!important;">';
            $view .= '<div class="custom-switches-stacked mt-2">';
            $view .= '<label class="custom-switch">';
            $view .= '<input type="checkbox" name="permission[]" value="'.$permission->id.'" class="custom-switch-input" '.$checked.'>';
            $view .= '<span class="custom-switch-indicator"></span>';
            $view .= '<span class="custom-switch-description">'.$permission->name.'</span>';
            $view .= '</label>';
            $view .= '</div>';
            $view .= '</div>';
        }
        $view .= '</div>';

        return $view;
    }

    public function manage(Request $request)
    {
        if($this->checkPermission('role.manage')) abort(404);

        DB::beginTransaction();
        try{
            $permissions = $request->permission;
            $role = Role::find($request->id);

            if(empty($permissions)){
                $role->permissions()->detach();
                DB::commit();

                return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah izin peran '. ucfirst($role->name)]);
            }

            for($i = 0; $i < count($permissions); $i++) {
                $perms[] = Permission::find($permissions[$i]);
            }

            foreach($perms as $perm) {
                $data[] = $perm->name;
            }

            if(!empty($role)){
                $role->updatePermissions($data);
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah izin peran '. ucfirst($role->name)]);;
    }

    public function destroy(Request $request)
    {
        if($this->checkPermission('role.delete')) abort(404);

        $destroy = Role::destroy($request->id);

        if($destroy) return response()->json(['status' => 'success', 'msg' => 'Berhasil menghapus peran']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal menghapus peran']);
    }

    public function setDefault(Request $request)
    {
        if($this->checkPermission('role.update')) abort(404);

        $roles = Role::all();
        $success_data = 0;

        DB::beginTransaction();
        try{
            foreach($roles as $role){
                if($role->id == $request->id){
                    $update = $role->update(['default_user' => 1]);
                } else {
                    $update = $role->update(['default_user' => 0]);
                }
                if($update){
                    $success_data = $success_data + 1;
                }
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($roles->count() == $success_data) return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah peran']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal mengubah peran']);
    }

    public function data()
    {
        if($this->checkPermission('role.view')) abort(404);

        $roles = Role::all();

        return DataTables::of($roles)
                    ->editColumn('default_user', function($role) {
                        $default_user = "";

                        if($role->default_user == 0) $default_user = "<a href='javascript:void(0)' tooltip='Jadikan sebagai default pengguna' data-id='{$role->id}' onclick='setDefault(this);'><i class='text-danger fas fa-ban'></i></a>";
                        if($role->default_user == 1) $default_user = "<a href='javascript:void(0)' tooltip='Default pengguna ketika mendaftar'><i class='text-success fas fa-check'></i></a>";

                        return $default_user;
                    })
                    ->editColumn('login_destination', function($role) {
                        $login_destination = "";

                        $login_destination = url($role->login_destination);

                        return $login_destination;
                    })
                    ->addColumn('action', function($role) {
                        $action = "";

                        if(auth()->user()->can('role.manage')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-success' tooltip='Mengelola Peran' data-id='{$role->id}' onclick='getManageRole(this);'><i class='fas fa-tasks'></i></a>&nbsp;";
                        if(auth()->user()->can('role.update')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' tooltip='Memperbarui Peran' data-id='{$role->id}' onclick='getUpdateRole(this);'><i class='far fa-edit'></i></a>&nbsp;";
                        if(auth()->user()->can('role.delete')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger' tooltip='Menghapus Peran' data-id='{$role->id}' onclick='deleteRole(this);'><i class='fas fa-trash'></i></a>&nbsp;";

                        return $action;
                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }

    public function list(Request $request)
    {
        $term = $request->data['term'];

        $search = Role::where('name', 'like', '%'.$term.'%')->get();

        if(auth()->user()->roles->first()->name != 'developer'){
            $search = Role::where('name', 'like', '%'.$term.'%')->where('id', '!=', 1)->get();
        }

        return response()->json($search);
    }

    protected function validator(array $data, $type = 'insert')
    {
        $name = 'unique:roles,name';

        if($type == 'update'){
            $name = '';
        }

        $message = [
            'required' => ':attribute tidak boleh kosong',
            'string' => ':attribute harus bertipe String',
            'min' => ':attribute minimal :min karakter',
            'max' => ':attribute maksimal :max karakter',
            'alpha_num' => ':attribute tidak boleh ada spasi',
            'unique' => ':attribute sudah terdaftar',
        ];

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191', 'alpha_num', $name],
            'login_destination' => ['required', 'string', 'max:191'],
        ], $message);
    }

    protected function checkPermission($permission)
    {
        return (bool) (!auth()->user()->can($permission));
    }
}
