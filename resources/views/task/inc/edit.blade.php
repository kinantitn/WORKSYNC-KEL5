@extends('adminlte::page')
@section('content')
    <input type="hidden" id="id_task_edit" value="{{ $data->id_task }}">
    <input type="hidden" id="id_project_edit" value="{{ $data->id_proyek }}">
    <div class="form-group">
        <label>Penanggung Jawab Task</label>
        <select class="form-control" id="id_employe_edit" name="id_employe[]" multiple="multiple">
            @foreach($pegawai as $item)
                <option value="{{ $item->id_pegawai }}">{{ $item->nama_lengkap }}</option>
            @endforeach
        </select>
        <input type="hidden" id="employee_edit" class="form-control" value="{{ $data->id_pegawai }}">
    </div>
    <div class="form-group">
        <label>Label Task</label>
        <input type="text" class="form-control" placeholder="nama task" id="label_task_edit" value="{{ $data->label_task }}">
    </div>
    <div class="form-group">
        <label>Deskripsi Task</label>
        <input type="text" class="form-control" placeholder="nama task" id="description_task_edit" value="{{ $data->deskripsi_task }}">
    </div>
    <div class="form-group">
        <label>Tanggal Plan Awal</label>
        <input type="date" class="form-control" id="start_date_plan_task_edit" value="{{ $data->tanggal_plan_awal }}">
    </div>
    <div class="form-group">
        <label>Tanggal Plan Akhir</label>
        <input type="date" class="form-control" id="end_date_plan_task_edit" value="{{ $data->tanggal_plan_akhir }}">
    </div>
{{--    <div class="form-group">--}}
{{--        <label>Tanggal Aktual Awal</label>--}}
{{--        <input type="date" class="form-control" id="start_date_actual_task_edit" value="{{ $data->tanggal_aktual_awal }}">--}}
{{--    </div>--}}
{{--    <div class="form-group">--}}
{{--        <label>Tanggal Aktual Akhir</label>--}}
{{--        <input type="date" class="form-control" id="end_date_actual_task_edit" value="{{ $data->tanggal_aktual_akhir }}">--}}
{{--    </div>--}}
    <div class="form-group">
        <label>Progress</label>
        <input type="int" class="form-control" id="progress_task_edit" value="{{ $data->presentase_progress }}" disabled>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" id="status_task_edit">
            <option value="{{ $data->status }}">{{ $data->status }}</option>
            <option>new</option>
            <option>todo</option>
            <option>in progress</option>
            <option>done</option>
        </select>
    </div>
@endsection
