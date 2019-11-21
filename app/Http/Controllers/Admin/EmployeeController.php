<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('admin.employee');
    }

    public function store(Request $request)
    {
        if($this->checkPermission('employee.create')) abort(404);

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

            $nip = $request->nip;
            $gender = $request->gender;
            $address = $request->address;
            $religion = $request->religion;

            $data = [
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
            ];

            $data_employee = [
                'nip' => $nip,
                'gender' => $gender,
                'address' => $address,
                'religion' => $religion,
            ];

            $insert = User::create($data);

            $employee = $insert->employee()->create($data_employee);

            $presence = $employee->createPresence();

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($presence) return response()->json(['status' => 'success', 'title' => 'Sukses!', 'msg' => 'Berhasil menambahkan karyawan']);

        return response()->json(['status' => 'error', 'title' => 'Gagal!', 'msg' => 'Gagal menambahkan karyawan']);
    }

    public function edit(Request $request)
    {
        if($this->checkPermission('user.update')) abort(404);

        $employee = Employee::find($request->id);
        $user = $employee->user;

        return response()->json(['status' => 'success', 'data' => ['employee' => $employee, 'user' => $user]]);
    }

    public function update(Request $request)
    {
        if($this->checkPermission('employee.update')) abort(404);

        DB::beginTransaction();
        try{
            $validator = $this->validator($request->all(), 'update');

            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $employee = Employee::find($request->id);

            $user = $employee->user;

            $username = $user->username;
            $name = $request->name;
            $email = $user->email;
            $password = $user->password;
            $phone = $user->phone;

            $nip = $employee->nip;
            $gender = $request->gender;
            $address = $request->address;
            $religion = $request->religion;

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

            if($nip != $request->nip){
                $check_nip = Employee::where('nip', '=', $request->nip)->get()->count();

                if($check_nip != 0){
                    return response()->json(['status' => 'warning', 'msg' => 'NIP yang Anda masukkan sudah terdaftar']);
                }

                $nip = $request->nip;
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

            $data_employee = [
                'nip' => $nip,
                'gender' => $gender,
                'address' => $address,
                'religion' => $religion,
            ];

            $update = $user->update($data);

            $employee = $user->employee()->update($data_employee);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($employee) return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah karyawan']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal mengubah karyawan']);
    }

    public function destroy(Request $request)
    {
        if($this->checkPermission('user.delete')) abort(404);

        DB::beginTransaction();
        try{
            $employee = Employee::find($request->id);
            $user = $employee->user;

            if($user->profile_picture != null){
                Storage::delete($user->profile_picture);
            }

            $destroy = $user->delete();

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'title' => 'Sukses!', 'msg' => $e->getMessage()]);
        }

        if($destroy) return response()->json(['status' => 'success', 'msg' => 'Berhasil menghapus karyawan']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal menghapus karyawan']);
    }

    public function data()
    {
        if($this->checkPermission('employee.view')) abort(404);

        $employees = Employee::all();

        return DataTables::of($employees)
                    ->addColumn('username', function($employee) {
                        $username = "";

                        $username = $employee->user->username;

                        return $username;
                    })
                    ->addColumn('name', function($employee) {
                        $name = "";

                        $name = $employee->user->name;

                        return $name;
                    })
                    ->addColumn('email', function($employee) {
                        $email = "";

                        $email = $employee->user->email;

                        return $email;
                    })
                    ->addColumn('phone', function($employee) {
                        $phone = "";

                        $phone = $employee->user->phone;

                        return $phone;
                    })
                    ->editColumn('address', function($employee) {
                        $address = "";

                        $address = Str::limit($employee->address, 30, '...');

                        return $address;
                    })
                    ->addColumn('action', function($employee) {
                        $action = "";

                        if(auth()->user()->can('employee.update')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' tooltip='Memperbarui Karyawan' data-id='{$employee->id}' onclick='getUpdateEmployee(this);'><i class='far fa-edit'></i></a>&nbsp;";
                        if(auth()->user()->can('employee.delete')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger' tooltip='Menghapus Karyawan' data-id='{$employee->id}' onclick='deleteEmployee(this);'><i class='fas fa-trash'></i></a>&nbsp;";

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
        $nip = 'unique:employees,nip';

        if($type == 'update'){
            $username = '';
            $email = '';
            $password = [];
            $phone = '';
            $nip = '';
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
            'nip' => ['required', 'string', 'numeric', $nip],
            'gender' => ['required', 'string'],
            'address' => ['required', 'string'],
            'religion' => ['required', 'string'],
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
