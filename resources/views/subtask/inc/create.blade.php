@extends('adminlte::page')
@section('content')
    <input type="hidden" id="id_project" value="{{ $data->id_proyek }}">
    <input type="hidden" id="id_task" value="{{ $data->id_task }}">
    <div class="form-group">
        <label>Penanggung Jawab Subtask</label>
        <select class="form-control id_employe_subtask" id="id_employe_subtask" multiple="multiple">
            @foreach($pegawai as $item)
                <option value="{{ $item->id_pegawai }}">{{ $item->nama_lengkap }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Label Activity</label>
        <input type="text" class="form-control" placeholder="nama task" id="label_activity">
    </div>
    <div class="form-group">
        <label>Deskripsi Activity</label>
        <input type="text" class="form-control" placeholder="nama task" id="description_activity">
    </div>
    <div class="form-group">
        <label>Tanggal Plan Awal</label>
        <input type="date" class="form-control" id="start_date_plan_activity">
    </div>
    <div class="form-group">
        <label>Tanggal Plan Akhir</label>
        <input type="date" class="form-control" id="end_date_plan_activity">
    </div>
{{--    <div class="form-group">--}}
{{--        <label>Tanggal Aktual Awal</label>--}}
{{--        <input type="date" class="form-control" id="start_date_actual_activity" disabled>--}}
{{--    </div>--}}
{{--    <div class="form-group">--}}
{{--        <label>Tanggal Aktual Akhir</label>--}}
{{--        <input type="date" class="form-control" id="end_date_actual_activity" disabled>--}}
{{--    </div>--}}
    <div class="form-group">
        <label>Progress</label>
        <input type="int" class="form-control" id="progress_activity" disabled value="0">
    </div>
@endsection
