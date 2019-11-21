<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PresenceType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PresenceTypeController extends Controller
{
    public function index()
    {
        return view('admin.presence.type');
    }


    public function store(Request $request)
    {
        if($this->checkPermission('presence_type.create')) abort(404);

        DB::beginTransaction();
        try{
            $validator = $this->validator($request->all());

            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $data = [
                'name' => $request->name,
            ];

            $insert = PresenceType::create($data);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($insert) return response()->json(['status' => 'success', 'msg' => 'Berhasil menambahkan jenis kehadiran']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal menambahkan jenis kehadiran']);
    }

    public function edit(Request $request)
    {
        if($this->checkPermission('presence_type.update')) abort(404);

        $presence_type = PresenceType::find($request->id);

        return response()->json(['status' => 'success', 'data' => $presence_type]);
    }

    public function update(Request $request)
    {
        if($this->checkPermission('presence_type.update')) abort(404);

        DB::beginTransaction();
        try{
            $validator = $this->validator($request->all());

            if($validator->fails()){
                return response()->json(['status' => 'warning', 'msg' => $validator->errors()->first()]);
            }

            $presence_type = PresenceType::find($request->id);

            $name = $request->name;
            $data = [
                'name' => $name,
            ];

            $update = $presence_type->update($data);

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => $e->getMessage()]);
        }

        if($update) return response()->json(['status' => 'success', 'msg' => 'Berhasil mengubah jenis kehadiran']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal mengubah jenis kehadiran']);
    }

    public function destroy(Request $request)
    {
        if($this->checkPermission('presence_type.delete')) abort(404);

        $destroy = PresenceType::destroy($request->id);

        if($destroy) return response()->json(['status' => 'success', 'msg' => 'Berhasil menghapus jenis kehadiran']);

        return response()->json(['status' => 'error', 'msg' => 'Gagal menghapus jenis kehadiran']);
    }

    public function data()
    {
        if($this->checkPermission('presence_type.view')) abort(404);

        $presence_types = PresenceType::all();

        return DataTables::of($presence_types)
                    ->addColumn('action', function($presence_type) {
                        $action = "";

                        if(auth()->user()->can('presence_type.update')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-primary' tooltip='Memperbarui Jenis Kehadiran' data-id='{$presence_type->id}' onclick='getUpdatePresenceType(this);'><i class='far fa-edit'></i></a>&nbsp;";
                        if(auth()->user()->can('presence_type.delete')) $action .= "<a href='javascript:void(0)' class='btn btn-icon btn-danger' tooltip='Menghapus Jenis Kehadiran' data-id='{$presence_type->id}' onclick='deletePresenceType(this);'><i class='fas fa-trash'></i></a>&nbsp;";

                        return $action;
                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }

    protected function validator(array $data)
    {

        $message = [
            'required' => ':attribute tidak boleh kosong',
            'string' => ':attribute harus bertipe String',
            'max' => ':attribute maksimal :max karakter',
        ];

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191'],
        ], $message);
    }

    protected function checkPermission($permission)
    {
        return (bool) (!auth()->user()->can($permission));
    }
}
