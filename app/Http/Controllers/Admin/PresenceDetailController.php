<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PresenceDetailController extends Controller
{
    public function data(Presence $presence)
    {
        if($this->checkPermission('presence_detail.view')) abort(404);

        $presence_details = $presence->presenceDetails;

        if($presence->id == null) $presence_details = PresenceDetail::get();

        return DataTables::of($presence_details)
                    ->addColumn('nip', function($presence_detail) {
                        $nip = "";

                        $nip = $presence_detail->presence->employee->nip;

                        return $nip;
                    })
                    ->addColumn('name', function($presence_detail) {
                        $name = "";

                        $name = $presence_detail->presence->employee->user->name;

                        return $name;
                    })
                    ->addColumn('date', function($presence_detail) {
                        $date = "";

                        $date = Carbon::parse($presence_detail->created_at)->format('Y-m-d');

                        return $date;
                    })
                    ->addColumn('total_time', function($presence_detail) {
                        $total_time = "";

                        $total_time = "9 Jam";

                        return $total_time;
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
