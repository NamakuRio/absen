@extends('templates.master')

@section('content')
<div class="section-header">
    <h1>Pengaturan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Beranda</a></div>
        <div class="breadcrumb-item">Pengaturan</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Pengaturan</h2>
    <p class="section-lead">
        Atur dan sesuaikan semua pengaturan tentang situs ini.
    </p>

    <div class="row">
        @foreach ($setting_groups as $setting_group)
            <div class="col-lg-6">
                <div class="card card-large-icons">
                    <div class="card-icon bg-primary text-white">
                        <i class="{{ $setting_group->icon }}"></i>
                    </div>
                    <div class="card-body">
                        <h4>{{ $setting_group->name }}</h4>
                        <p>{{ $setting_group->description }}</p>
                        <a href="{{ route('admin.setting.show', ['setting_group' => $setting_group]) }}" class="card-cta">Ubah Pengaturan <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
