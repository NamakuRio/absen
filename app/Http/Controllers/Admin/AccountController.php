<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account');
    }

    public function update(Request $request)
    {
        $validator = $this->validator($request->all());

        DB::beginTransaction();
        try{
            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $user = User::find(auth()->user()->id);

            $username = $user->username;
            $name = $request->name;
            $email = $user->email;
            $password = $user->password;
            $phone = $user->phone;
            $photo = $user->photo;

            if($username != $request->username){
                $check_username = User::where('username', '=', $request->username)->get()->count();

                if($check_username != 0){
                    return response()->json(['status' => 'warning', 'msg' => 'Username yang Anda masukkan sudah terdaftar']);
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

            if($request->has('photo')){
                Storage::delete($photo);
                $photo = $request->file('photo')->store('uploads/user/photo');
            }

            if($request->null_photo){
                Storage::delete($photo);
                $photo = null;
            }

            $data = [
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'photo' => $photo,
            ];

            $update = $user->update($data);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($update) return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah profile Anda']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal mengubah profile Anda.']);
    }

    protected function validator(array $data)
    {
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'email' => ':attribute tidak valid',
            'string' => ':attribute harus bertipe String',
            'min' => ':attribute minimal :min karakter',
            'max' => ':attribute maksimal :max karakter',
            'apha_num' => ':attribute tidak boleh ada spasi',
            'confirmed' => ':atrribute yang dimasukkan tidak sama',
            'file' => ':atrribute harus berupa file',
            'mimes' => ':atrribute harus bertipe :mimes',
        ];

        return Validator::make($data, [
            'username' => ['required', 'string', 'min:6', 'max:191','alpha_num'],
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'password' => ['confirmed'],
            'phone' => ['required', 'string', 'numeric'],
            'photo' => ['file', 'mimes:png,jpg,jpeg']
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
            $email = str_replace('.', '', $email);
        }

        return $email;
    }

    protected function checkPermission($permission)
    {
        return (bool) (!auth()->user()->can($permission));
    }
}
