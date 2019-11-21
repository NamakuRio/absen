@extends('templates.master')

@section('css-library')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.presence') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Detail Kehadiran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Beranda</a></div>
            <div class="breadcrumb-item">Detail Kehadiran</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Detail Kehadiran</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="presence-detail-list">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10">
                                            #
                                        </th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Masuk</th>
                                        <th>Waktu Keluar</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-library')
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
@endsection

@section('js-script')
    <script>
        $(function () {
            "use strict";

            getPresenceDetails();

        });

        async function getPresenceDetails()
        {
            $("#presence-detail-list").dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.presence_detail.data', ['presence' => $presence]) }}",
                destroy: true,
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'nip' },
                    { data: 'name' },
                    { data: 'date' },
                    { data: 'time_entry' },
                    { data: 'time_out' },
                    { data: 'total_time' },
                ]
            });
        }
    </script>
@endsection
