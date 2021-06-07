@extends('adminlte::page')
@section('content')
    <input type="hidden" value="{{ $data->id_proyek }}" id="id_edit">
    <div class="form-group">
        <label>Nama Proyek</label>
        <input id="name_edit" type="text" class="form-control" placeholder="nama proyek" value="{{ $data->nama_proyek }}">
    </div>
    <div class="form-group">
        <label>Penanggung Jawab Proyek</label>
        <select class="form-control" id="id_employe_edit" name="id_employe[]" multiple="multiple">
            @foreach($pegawai as $item)
                <option value="{{ $item->id_pegawai }}">{{ $item->nama_lengkap }}</option>
            @endforeach
        </select>
        <input type="hidden" id="employee_edit" class="form-control" value="{{ $data->id_pegawai }}">
    </div>
    <div class="form-group">
        <label>Tanggal Plan Awal</label>
        <input id="start_date_plan_edit" type="date" class="form-control" value="{{ $data->tanggal_plan_awal_proyek }}">
    </div>
    <div class="form-group">
        <label>Tanggal Plan Akhir</label>
        <input id="end_date_plan_edit" type="date" class="form-control" value="{{ $data->tanggal_plan_akhir_proyek }}">
    </div>
    <div class="form-group">
        <label>Tanggal Aktual Awal</label>
        <input id="start_date_actual_edit" type="date" class="form-control" value="{{ $data->tanggal_aktual_awal_proyek }}">
    </div>
    <div class="form-group">
        <label>Tanggal Aktual Akhir</label>
        <input id="end_date_actual_edit" type="date" class="form-control" value="{{ $data->tanggal_aktual_akhir_proyek }}">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select id="status_edit" class="form-control">
            <option value="{{ $data->status }}">{{ $data->status }}</option>
            <option>New</option>
            <option>In Progress</option>
            <option>Done</option>
        </select>
    </div>
@endsection
