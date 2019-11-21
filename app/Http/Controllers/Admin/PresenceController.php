<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PresenceController extends Controller
{
    public function index()
    {
        return view('admin.presence.index');
    }

    public function show(Presence $presence)
    {
        return view('admin.presence.show', compact('presence'));
    }

    public function data()
    {
        if($this->checkPermission('presence.view')) abort(404);

        $presences = Presence::all();

        return DataTables::of($presences)
                    ->editColumn('total_time', function($presence) {
                        $total_time = "";

                        $total_time = $presence->total_time . " Jam";

                        return $total_time;
                    })
                    ->addColumn('nip', function($presence) {
                        $nip = "";

                        $nip = $presence->employee->nip;

                        return $nip;
                    })
                    ->addColumn('name', function($presence) {
                        $name = "";

                        $name = $presence->employee->user->name;

                        return $name;
                    })
                    ->addColumn('action', function($presence) {
                        $action = "";

                        if(auth()->user()->can('presence.view')) $action .= "<a href='".route('admin.presence.show', ['presence' => $presence])."' class='btn btn-icon btn-primary' tooltip='Detail Kehadiran'><i class='far fa-eye'></i></a>&nbsp;";

                        return $action;
                    })
                    ->escapeColumns([])
                    ->addIndexColumn()
                    ->make(true);
    }

    protected function checkPermission($permission)
    {
        return (bool) (!auth()->user()->can($permission));
    }
}
