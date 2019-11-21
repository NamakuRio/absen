<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user');
    }

    public function store(Request $request)
    {
        if($this->checkPermission('user.create')) abort(404);
        if(!$this->checkRole($request->role)) abort(404);

        DB::beginTransaction();
        try{
            $validator = $this->validator($request->all());

            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $username = $request->username;
            $name = $request->name;
            $email = $this->checkEmail($request->email);
            $password = bcrypt($request->password);
            $phone = $this->checkPhone($request->phone);

            $data = [
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
            ];

            $insert = User::create($data);

            $role = Role::find($request->role);

            if(!$role) {
                return response()->json(['status' => 'warning', 'msg' => 'Role tidak ditemukan']);
            }

            $insert->assignRole($role->name);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($insert) return response()->json(['status' => 'success', 'title' => 'Sukses!', 'msg' => 'Berhasil menambahkan pengguna']);

        return response()->json(['status' => 'error', 'title' => 'Gagal!', 'msg' => 'Gagal menambahkan pengguna']);
    }

    public function edit(Request $request)
    {
        if($this->checkPermission('user.update')) abort(404);

        $user = User::find($request->id);
        $role = $user->roles->first();

        return response()->json(['status' => 'success', 'data' => ['user' => $user, 'role' => $role]]);
    }

    public function update(Request $request)
    {
        if($this->checkPermission('user.update')) abort(404);

        DB::beginTransaction();
        try{
            $validator = $this->validator($request->all(), 'update');

            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $user = User::find($request->id);

            $username = $user->username;
            $name = $request->name;
            $email = $user->email;
            $password = $user->password;
            $phone = $user->phone;

            if($username != $request->username){
                $check_username = User::where('username', '=', $request->username)->get()->count();

                if($check_username != 0){
                    return response()->json(['status' => 'warning', 'msg' => 'Nama pengguna yang Anda masukkan sudah terdaftar']);
                }

                $username = $request->username;
            }

            if($email != $this->checkEmail($request->email)){
                $check_email = User::where('email', '=', $this->checkEmail($request->email))->get()->count();

                if($check_email != 0){
                    return response()->json(['status' => 'warning', 'msg' => 'Email yang Anda masukkan sudah terdaftar']);
                }

                $email = $this->checkEmail($request->email);
            }

            if($phone != $this->checkPhone($request->phone)){
                $check_phone = User::where('phone', '=', $this->checkPhone($request->phone))->get()->count();

                if($check_phone != 0){
                    return response()->json(['status' => 'warning', 'msg' => 'No HP yang Anda masukkan sudah terdaftar']);
                }

                $phone = $this->checkPhone($request->phone);
            }

            if($request->password != null){
                $password = bcrypt($request->password);
            }

            $data = [
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
            ];

            $update = $user->update($data);

            $role = Role::find($request->role);

            $user->syncRoles($role->name);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($update) return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah pengguna']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal mengubah pengguna']);
    }

    public function getManage(Request $request)
    {
        if($this->checkPermission('user.manage')) abort(404);

        $permissions = Permission::all();
        $user = User::find($request->id);
        $view = "";

        $view .= '<input type="hidden" id="manage-user-id" name="id" value="'.$user->id.'" required>';

        $view .= '<div class="row">';
        $view .= '<div class="col-12 text-center">';
        $view .= '<h4>User '.ucfirst($user->name).'</h4>';
        $view .= '</div>';

        foreach($permissions as $permission){
            $checked = '';
            $fromRole = '';
            $setDisabled = '';

            foreach($permission->users as $user_permission){
                if($user->id == $user_permission->id){
                    $checked = 'checked';
                }
            }

            foreach($permission->roles as $role_permission){
                if($user->roles->first()->id == $role_permission->id){
                    $checked = 'checked';
                    $fromRole = "(Role Active)";
                    $setDisabled = "disabled";
                }
            }

            $view .= '<div class="form-group col-lg-6" style="margin:0!important;">';
            $view .= '<div class="custom-switches-stacked mt-2">';
            $view .= '<label class="custom-switch">';
            $view .= '<input type="checkbox" name="permission[]" value="'.$permission->id.'" class="custom-switch-input" '.$checked.' '.$setDisabled.'>';
            $view .= '<span class="custom-switch-indicator"></span>';
            $view .= '<span class="custom-switch-description">'.$permission->name.' '.$fromRole.'</span>';
            $view .= '</label>';
            $view .= '</div>';
            $view .= '</div>';
        }
        $view .= '</div>';

        return $view;
    }

    public function manage(Request $request)
    {
        if($this->checkPermission('user.manage')) abort(404);

        DB::beginTransaction();
        try{
            $permissions = $request->permission;
            $user = User::find($request->id);

            if(empty($permissions)){
                $user->permissions()->detach();

                return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah izin pengguna '. ucfirst($user->name)]);
            }

            for($i = 0; $i < count($permissions); $i++) {
                $perms[] = Permission::find($permissions[$i]);
            }

            foreach($perms as $perm) {
                $data[] = $perm->name;
            }

            if(!empty($user)){
                $user->updatePermissions($data);
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah izin pengguna '. ucfirst($user->name)]);;
    }

    public function destroy(Request $request)
    {
        if($this->checkPermission('user.delete')) abort(404);

        DB::beginTransaction();
        try{
            $user = User::find($request->id);

            if($user->profile_picture != null){
                Storage::delete($user->profile_picture);
            }

            $destroy = $user->delete();

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'title' => 'Sukses!', 'msg' => $e->getMessage()]);
        }

        if($destroy) return response()->json(['status' => 'success', 'msg' => 'Berhasil menghapus pengguna']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal menghapus pengguna']);
    }

    public function data()
    {
        if($this->checkPermission('user.view')) abort(404);

        $users = User::all();

        return DataTables::of($users)
                    ->addColumn('role_name', function($user) {
                        $role_name = "";

                        if($user->roles->first()->name == "developer") $role_name = "<span class='badge badge-primary'>".$user->roles->first()->name."</span>";
                        if($user->roles->first()->name == "admin") $role_name = "<span class='badge badge-info'>".$user->roles->first()->name."</span>";

                        return $role_name;
                    })
                    ->addColumn('action', function($user) {
                        $action = "";

                        $user_role = $user->roles->first()->name;

                        if($user_role == 'developer' && auth()->user()->roles->first()->name != 'developer'){
                            $action .= "";
                        } else {
                            if(auth()->user()->can('user.manage')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-success' tooltip='Mengelola Pengguna' data-id='{$user->id}' onclick='getManageUser(this);'><i class='fas fa-tasks'></i></a>&nbsp;";
                            if(auth()->user()->can('user.update')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' tooltip='Memperbarui Pengguna' data-id='{$user->id}' onclick='getUpdateUser(this);'><i class='far fa-edit'></i></a>&nbsp;";
                            if(auth()->user()->can('user.delete')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger' tooltip='Menghapus Pengguna' data-id='{$user->id}' onclick='deleteUser(this);'><i class='fas fa-trash'></i></a>&nbsp;";
                        }

                        return $action;
                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }

    protected function validator(array $data, $type = 'insert')
    {
        $data['email'] = $this->checkEmail($data['email']);
        $data['phone'] = $this->checkPhone($data['phone']);

        $username = 'unique:users,username';
        $email = 'unique:users,email';
        $password = ['string', 'min:8', 'max:191', 'confirmed'];
        $phone = 'unique:users,phone';

        if($type == 'update'){
            $username = '';
            $email = '';
            $password = [];
            $phone = '';
        }

        $message = [
            'required' => ':attribute tidak boleh kosong',
            'string' => ':attribute harus bertipe String',
            'min' => ':attribute minimal :min karakter',
            'max' => ':attribute maksimal :max karakter',
            'apha_num' => ':attribute tidak boleh ada spasi',
            'unique' => ':attribute sudah terdaftar',
            'email' => ':attribute tidak valid',
            'confirmed' => ':atrribute yang dimasukkan tidak sama',
            'numeric' => ':atrribute harus berupa angka',
        ];

        return Validator::make($data, [
            'username' => ['required', 'string', 'min:6', 'max:191','alpha_num', $username],
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', $email],
            'password' => $password,
            'phone' => ['required', 'string', 'numeric', $phone],
            'role' => ['required', 'string', 'max:191'],
        ], $message);
    }

    protected function checkPhone($phone)
    {
        $phone_dot = str_replace('.', '', $phone);
        $phone_space = str_replace(' ', '', $phone_dot);
        $phone_id = $phone_space[0].$phone_space[1];

        if($phone_id == "08"){
            $phone_space = str_replace('08', '628', $phone_space);
        }

        return $phone_space;
    }

    protected function checkEmail($email)
    {
        list($username, $domain) = explode('@', $email);

        if($domain == 'gmail.com'){
            $check = str_replace('.', '', $username);

            $email = $check."@".$domain;
        }

        return $email;
    }

    protected function checkRole($role)
    {
        if($role == '1' && auth()->user()->roles->first()->id != '1') return false;

        return true;
    }

    protected function checkPermission($permission)
    {
        return (bool) (!auth()->user()->can($permission));
    }
}
