@extends('adminlte::page')
@section('content')
    <input type="hidden" id="id_project_edit" value="{{ $data->task->id_proyek }}">
    <input type="hidden" id="id_task_edit" value="{{ $data->id_task }}">
    <input type="hidden" id="id_activity_edit" value="{{ $data->id_activity }}">
    @if(auth()->user()->role === 'manager')
    <div class="form-group">
        <label>Penanggung Jawab Subtask</label>
        <select class="form-control" id="id_employe_edit" name="id_employe[]" multiple="multiple">
            @foreach($pegawai as $item)
                <option value="{{ $item->id_pegawai }}">{{ $item->nama_lengkap }}</option>
            @endforeach
        </select>
        <input type="hidden" id="employee_edit" class="form-control" value="{{ $data->id_pegawai }}">
    </div>
    <div class="form-group">
        <label>Label Activity</label>
        <input type="text" class="form-control" placeholder="nama task" id="label_activity_edit" value="{{ $data->label_activity }}">
    </div>
    <div class="form-group">
        <label>Deskripsi Activity</label>
        <input type="text" class="form-control" placeholder="nama task" id="description_activity_edit" value="{{ $data->deskripsi_activity }}">
    </div>
    <div class="form-group">
        <label>Tanggal Plan Awal</label>
        <input type="date" class="form-control" id="start_date_plan_activity_edit" value="{{ $data->tanggal_plan_awal }}">
    </div>
    <div class="form-group">
        <label>Tanggal Plan Akhir</label>
        <input type="date" class="form-control" id="end_date_plan_activity_edit" value="{{ $data->tanggal_plan_akhir }}">
    </div>
        @if ($data->status === "done")
        <div class="form-group">
            <label>Tanggal Aktual Awal</label>
            <input type="date" class="form-control" id="start_date_actual_activity_edit" value="{{ $data->tanggal_aktual_awal }}" disabled>
        </div>
        <div class="form-group">
            <label>Tanggal Aktual Akhir</label>
            <input type="date" class="form-control" id="end_date_actual_activity_edit" value="{{ $data->tanggal_aktual_akhir }}" disabled>
        </div>
        @endif
    @endif
    <div class="form-group">
        <label>Progress</label>
        <input type="int" class="form-control" id="progress_activity_edit" value="{{ $data->presentase_progress }}">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" id="status_activity_edit">
            <option value="{{ $data->status }}">{{ $data->status }}</option>
            <option>new</option>
            <option>todo</option>
            <option>in progress</option>
            <option>done</option>
        </select>
    </div>
@endsection
