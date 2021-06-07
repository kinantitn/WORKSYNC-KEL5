@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Daftar Task & Subtask - Proyek {{ $project['nama_proyek'] }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{  url('project') }}">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Task & Subtask</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-row card-dark">
                <div class="card-header">
                    <h3 class="card-title">
                        Filter
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-1">
                            <a href="{{ url('project/'. $project['id_proyek']) }}" class="btn btn-success">
                                Semua
                            </a>
                            {{--                        <a href="{{ url('project/'. $project->id_proyek.'/?filter=harian') }}" class="btn btn-success">--}}
                            {{--                            --}}
                            {{--                        </a>--}}
                            {{--                        <a href="{{ url('project/'. $project->id_proyek.'/?filter=mingguan') }}" class="btn btn-success">--}}
                            {{--                            Mingguan--}}
                            {{--                        </a>--}}
                        </div>
                        <div class="form-group col-md-3">
                            <input class="form-control" name="daterange" id="date">
                            <input type="hidden" id="id_project_global" value="{{ $project['id_proyek'] }}">
{{--                            <input type="hidden" id="progress_project" value="{{ $progress }}">--}}
{{--                            {{ $progress }}--}}
                        </div>
                        <div class="form-group col-md-1">
                            <a href="#" onclick="filterTask(this)" data-project="{{ $project['id_proyek'] }}" class="btn btn-success">
                                Cari
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-row card-blue">
                <div class="card-header">
                    <h3 class="card-title">
                        Task
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table width="100%">
                            <thead>
                            <th>Task</th>
                            <th>Deskripsi</th>
                            <th>Start & End Date</th>
                            </thead>
                            <tbody>
                            @foreach($task as $item)
                                <tr class="border_bottom">
                                    <td>{{ $item['label_task'] }}</td>
                                    <td>{{ $item['deskripsi_task'] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $item['tanggal_plan_akhir'] )) }}</td>
                                </tr>
                            @endforeach

                            @foreach($activity as $item)
                                <tr class="border_bottom">
                                    <td>{{ $item['label_activity'] }}</td>
                                    <td>{{ $item['deskripsi_activity'] }}</td>
                                    <td>{{ date('d-m-Y', strtotime($item['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $item['tanggal_plan_akhir'] )) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <canvas id="myChart4"></canvas>
        </div>

        <div class="col-md-12">&nbsp;</div>
        <div class="col-md-3">
            <div class="card card-row card-secondary">
                <div class="card-header">
                    @if(auth()->user()->role === 'manager')
                        <a href="#" onclick="handleCreateTask(this,event)" class="btn btn-sm btn-primary pull-right" style="float: right">
                            <i class="fa fa-plus"></i>
                            Task
                        </a>
{{--                    <button onclick="handleCreateTask(this,event)" class="btn btn-sm btn-primary pull-right" style="float: right">--}}
{{--                        --}}
{{--                    </button>--}}
                    @else
                        <h3 class="card-title">
                            Task
                        </h3>
                    @endif
                </div>
                <div class="card-body">
                    @foreach($task->where('status','new')  as $key => $item)
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h5 class="card-title">
                                <mark style="background-color: darkseagreen">task {{ $item['label_task'] }}</mark>
                                - {{ $item['presentase_progress'] .'%' }}
                            </h5>
                            <br>
                            <p style="color:blue;">
                                {{ date('d-m-Y', strtotime($item['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $item['tanggal_plan_akhir'] )) }}
                            </p>
                            <p style="color:green;">
                                {{ ($item['tanggal_aktual_awal']) ? date('d-m-Y', strtotime($item['tanggal_aktual_awal'] )) :'-' }} - {{ ($item['tanggal_aktual_akhir']) ?  date('d-m-Y', strtotime( $item['tanggal_aktual_akhir'] )) : ''}}
                            </p>
                            <p>
                                {{ $item['deskripsi_task'] }}
                            </p>
                            @if(auth()->user()->role === 'manager')
                            <div class="card-tools">
                                <a href="#" class="btn btn-link" data-project="{{ $project['id_proyek'] }}" data="{{ $item['id_task'] }}" onclick="handleDeleteTask(this,event)">
                                    <i class="fa fa-trash" style="color: indianred"></i>
                                </a>
                                <a href="#" class="btn btn-link" data="{{ $item['id_task'] }}" onclick="handleCreateSubtask(this,event)">
                                    <i class="fa fa-plus" ></i>
                                </a>

                            </div>
                            @endif

                            @php
                                $pieces = explode(',', $item['id_pegawai']);

                            @endphp

                            @if(in_array(auth()->user()->pegawai->id_pegawai, $pieces) || auth()->user()->role === 'manager')
                                <a href="" class="btn btn-link" data-project="{{ $project['id_proyek'] }}" data="{{ $item['id_task'] }}" onclick="handleEditTask(this,event)" >
                                    <i class="fa fa-pen" style="color: orange"></i>
                                </a>
                            @endif


                            <br><br>
                            <p style="font-size:8pt;">
                                @foreach($item['employee'] as $employee)
                                    <mark> {{ $employee}} </mark>
                                @endforeach
                            </p>
                        </div>
                    </div>
                    @endforeach

                    @foreach($activity->where('status','new') as $key => $subtask)
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <mark style="background-color: deepskyblue"> subtask from {{ $subtask['task'] }} </mark> <br>
                                    {{ $subtask['label_activity'] }} - {{ $subtask['presentase_progress'] .'%' }}
                                </h5>
                                <br>
                                <p style="color:blue;">
                                    {{ date('d-m-Y', strtotime($subtask['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $subtask['tanggal_plan_akhir'] )) }}
                                </p>
                                <p style="color:green;">
                                    {{ ($subtask['tanggal_aktual_awal']) ? date('d-m-Y', strtotime($subtask['tanggal_aktual_awal'] )) :'-' }} - {{ ($subtask['tanggal_aktual_akhir']) ?  date('d-m-Y', strtotime( $item['tanggal_aktual_akhir'] )) : ''}}
                                </p>
                                <p>
                                    {{ $subtask['deskripsi_activity'] }}
                                </p>
                                @if(auth()->user()->role === 'manager')
                                    <a href="" data-project="{{ $project['id_proyek'] }}" data="{{ $subtask['id_activity'] }}" onclick="handleDeleteSubtask(this, event)">
                                        <i class="fa fa-trash" style="color:indianred"></i>
                                    </a>
                                    &nbsp;
                                    @endif

                                @php
                                    $pieces = explode(',', $subtask['id_pegawai']);

                                @endphp

                                @if(in_array(auth()->user()->pegawai->id_pegawai, $pieces) || auth()->user()->role === 'manager')
                                <a href="" data-project="{{ $project['id_proyek'] }}" data="{{ $subtask['id_activity'] }}" onclick="handleEditSubtask(this, event)">
                                    <i class="fa fa-pen" style="color:orange"></i>
                                </a>
                                @endif

                                <br><br>
                                <p style="font-size:8pt;">
                                    @foreach($subtask['employee'] as $employee)
                                        <mark> {{ $employee}} </mark> &nbsp;
                                    @endforeach
                                </p>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-row card-primary">
                <div class="card-header">
                    Todo
                </div>
                <div class="card-body">
                    @foreach($task->where('status','todo')  as $key => $item)
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <mark style="background-color: darkseagreen">task {{ $item['label_task'] }}</mark>
                                    - {{ $item['presentase_progress'] .'%' }}
                                </h5>
                                <br>
                                <p style="color:blue;">
                                    {{ date('d-m-Y', strtotime($item['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $item['tanggal_plan_akhir'] )) }}
                                </p>
                                <p style="color:green;">
                                    {{ ($item['tanggal_aktual_awal']) ? date('d-m-Y', strtotime($item['tanggal_aktual_awal'] )) :'-' }} - {{ ($item['tanggal_aktual_akhir']) ?  date('d-m-Y', strtotime( $item['tanggal_aktual_akhir'] )) : ''}}
                                </p>
                                <p>
                                    {{ $item['deskripsi_task'] }}
                                </p>
                                @if(auth()->user()->role === 'manager')
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-link" data-project="{{ $project['id_proyek'] }}" data="{{ $item['id_task'] }}" onclick="handleDeleteTask(this,event)">
                                            <i class="fa fa-trash" style="color: indianred"></i>
                                        </a>
                                        <a href="#" class="btn btn-link" data="{{ $item['id_task'] }}" onclick="handleCreateSubtask(this,event)">
                                            <i class="fa fa-plus" ></i>
                                        </a>
                                    </div>
                                @endif

                                @php
                                    $pieces = explode(',', $item['id_pegawai']);

                                @endphp

                                @if(in_array(auth()->user()->pegawai->id_pegawai, $pieces) || auth()->user()->role === 'manager')
                                    <a href="" class="btn btn-link" data-project="{{ $project['id_proyek'] }}" data="{{ $item['id_task'] }}" onclick="handleEditTask(this,event)" >
                                        <i class="fa fa-pen" style="color: orange"></i>
                                    </a>
                                @endif
                                <br><br>
                                <p style="font-size:8pt;">
                                    @foreach($item['employee'] as $employee)
                                        <mark> {{ $employee}} </mark>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endforeach

                    @foreach($activity->where('status','todo') as $key => $subtask)
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <mark style="background-color: deepskyblue"> subtask from {{ $subtask['task'] }} </mark> <br>
                                    {{ $subtask['label_activity'] }} - {{ $subtask['presentase_progress'] .'%' }}
                                </h5>
                                <br>
                                <p style="color:blue;">
                                    {{ date('d-m-Y', strtotime($subtask['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $subtask['tanggal_plan_akhir'] )) }}
                                </p>
                                <p style="color:green;">
                                    {{ ($subtask['tanggal_aktual_awal']) ? date('d-m-Y', strtotime($subtask['tanggal_aktual_awal'] )) :'-' }} - {{ ($subtask['tanggal_aktual_akhir']) ?  date('d-m-Y', strtotime( $subtask['tanggal_aktual_akhir'] )) : ''}}
                                </p>
                                <p>
                                    {{ $subtask['deskripsi_activity'] }}
                                </p>
                                @if(auth()->user()->role === 'manager')
                                    <a href="" data-project="{{ $project['id_proyek'] }}" data="{{ $subtask['id_activity'] }}" onclick="handleDeleteSubtask(this, event)">
                                        <i class="fa fa-trash" style="color:indianred"></i>
                                    </a>
                                    &nbsp;
                                @endif

                                @php
                                    $pieces = explode(',', $subtask['id_pegawai']);

                                @endphp

                                @if(in_array(auth()->user()->pegawai->id_pegawai, $pieces) || auth()->user()->role === 'manager')
                                    <a href="" data-project="{{ $project['id_proyek'] }}" data="{{ $subtask['id_activity'] }}" onclick="handleEditSubtask(this, event)">
                                        <i class="fa fa-pen" style="color:orange"></i>
                                    </a>
                                @endif

                                <br><br>
                                <p style="font-size:8pt;">
                                    @foreach($subtask['employee'] as $employee)
                                        <mark> {{ $employee}} </mark> &nbsp;
                                    @endforeach
                                </p>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-row card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        In Progress
                    </h3>
                </div>
                <div class="card-body">
                    @foreach($task->where('status','in progress')  as $key => $item)
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <mark style="background-color: darkseagreen">task {{ $item['label_task'] }}</mark>
                                    - {{ $item['presentase_progress'] .'%' }}
                                </h5>
                                <br>
                                <p style="color:blue;">
                                    {{ date('d-m-Y', strtotime($item['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $item['tanggal_plan_akhir'] )) }}
                                </p>
                                <p style="color:green;">
                                    {{ ($item['tanggal_aktual_awal']) ? date('d-m-Y H:i:s', strtotime($item['tanggal_aktual_awal'] )) :'-' }} - {{ ($item['tanggal_aktual_akhir']) ?  date('d-m-Y H:i:s', strtotime( $item['tanggal_aktual_akhir'] )) : ''}}
                                </p>
                                <p>
                                    {{ $item['deskripsi_task'] }}
                                </p>
                                @if(auth()->user()->role === 'manager')
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-link" data-project="{{ $project['id_proyek'] }}" data="{{ $item['id_task'] }}" onclick="handleDeleteTask(this,event)">
                                            <i class="fa fa-trash" style="color: indianred"></i>
                                        </a>
                                        <a href="#" class="btn btn-link" data="{{ $item['id_task'] }}" onclick="handleCreateSubtask(this,event)">
                                            <i class="fa fa-plus" ></i>
                                        </a>
                                    </div>
                                @endif
                                @php
                                    $pieces = explode(',', $item['id_pegawai']);

                                @endphp

                                @if(in_array(auth()->user()->pegawai->id_pegawai, $pieces) || auth()->user()->role === 'manager')
                                    <a href="" class="btn btn-link" data-project="{{ $project['id_proyek'] }}" data="{{ $item['id_task'] }}" onclick="handleEditTask(this,event)" >
                                        <i class="fa fa-pen" style="color: orange"></i>
                                    </a>
                                @endif

                                <br><br>
                                <p style="font-size:8pt;">
                                    @foreach($item['employee'] as $employee)
                                        <mark> {{ $employee}} </mark>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endforeach

                    @foreach($activity->where('status','in progress') as $key => $subtask)
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <mark style="background-color: deepskyblue"> subtask from {{ $subtask['task'] }} </mark> <br>
                                    {{ $subtask['label_activity'] }} - {{ $subtask['presentase_progress'] .'%' }}
                                </h5>
                                <br>
                                <p style="color:blue;">
                                    {{ date('d-m-Y', strtotime($subtask['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $subtask['tanggal_plan_akhir'] )) }}
                                </p>
                                <p style="color:green;">
                                    {{ ($subtask['tanggal_aktual_awal']) ? date('d-m-Y H:i:s', strtotime($subtask['tanggal_aktual_awal'] )) :'-' }} - {{ ($subtask['tanggal_aktual_akhir']) ?  date('d-m-Y H:i:s', strtotime( $subtask['tanggal_aktual_akhir'] )) : ''}}
                                </p>
                                <p>
                                    {{ $subtask['deskripsi_activity'] }}
                                </p>
                                @if(auth()->user()->role === 'manager')
                                    <a href="" data-project="{{ $project['id_proyek'] }}" data="{{ $subtask['id_activity'] }}" onclick="handleDeleteSubtask(this, event)">
                                        <i class="fa fa-trash" style="color:indianred"></i>
                                    </a>
                                    &nbsp;
                                @endif

                                @php
                                    $pieces = explode(',', $subtask['id_pegawai']);

                                @endphp

                                @if(in_array(auth()->user()->pegawai->id_pegawai, $pieces) || auth()->user()->role === 'manager')
                                    <a href="" data-project="{{ $project['id_proyek'] }}" data="{{ $subtask['id_activity'] }}" onclick="handleEditSubtask(this, event)">
                                        <i class="fa fa-pen" style="color:orange"></i>
                                    </a>
                                @endif

                                <br><br>
                                <p style="font-size:8pt;">
                                    @foreach($subtask['employee'] as $employee)
                                        <mark> {{ $employee}} </mark> &nbsp;
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-row card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        Done
                    </h3>
                </div>
                <div class="card-body">
                    @foreach($task->where('status','done')  as $key => $item)
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <mark style="background-color: darkseagreen">task {{ $item['label_task'] }}</mark>
                                    - {{ $item['presentase_progress'] .'%' }}
                                </h5>
                                <br>
                                <p style="color:blue;">
                                    {{ date('d-m-Y', strtotime($item['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $item['tanggal_plan_akhir'] )) }}
                                </p>
                                <p style="color:green;">
                                    {{ ($item['tanggal_aktual_awal']) ? date('d-m-Y H:i:s', strtotime($item['tanggal_aktual_awal'] )) :'-' }} - {{ ($item['tanggal_aktual_akhir']) ?  date('d-m-Y H:i:s', strtotime( $item['tanggal_aktual_akhir'] )) : ''}}
                                </p>
                                <p>
                                    {{ $item['deskripsi_task'] }}
                                </p>
                                @if(auth()->user()->role === 'manager')
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-link" data-project="{{ $project->id_proyek }}" data="{{ $item['id_task'] }}" onclick="handleDeleteTask(this,event)">
                                            <i class="fa fa-trash" style="color: indianred"></i>
                                        </a>
                                        <a href="#" class="btn btn-link" data="{{ $item['id_task'] }}" onclick="handleCreateSubtask(this,event)">
                                            <i class="fa fa-plus" ></i>
                                        </a>
                                    </div>
                                @endif
                                @php
                                    $pieces = explode(',', $item['id_pegawai']);

                                @endphp

                                @if(in_array(auth()->user()->pegawai->id_pegawai, $pieces) || auth()->user()->role === 'manager')
                                    <a href="" class="btn btn-link" data-project="{{ $project['id_proyek'] }}" data="{{ $item['id_task'] }}" onclick="handleEditTask(this,event)" >
                                        <i class="fa fa-pen" style="color: orange"></i>
                                    </a>
                                @endif
                                <br><br>
                                <p style="font-size:8pt;">
                                    @foreach($item['employee'] as $employee)
                                        <mark> {{ $employee}} </mark>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endforeach

                    @foreach($activity->where('status','done') as $key => $subtask)
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <mark style="background-color: deepskyblue"> subtask from {{ $subtask['task'] }} </mark> <br>
                                    {{ $subtask['label_activity'] }} - {{ $subtask['presentase_progress'] .'%' }}
                                </h5>
                                <br>
                                <p style="color:blue;">
                                    {{ date('d-m-Y', strtotime($subtask['tanggal_plan_awal'] )) }} - {{ date('d-m-Y', strtotime( $subtask['tanggal_plan_akhir'] )) }}
                                </p>
                                <p style="color:green;">
                                    {{ ($subtask['tanggal_aktual_awal']) ? date('d-m-Y H:i:s', strtotime($subtask['tanggal_aktual_awal'] )) :'-' }} - {{ ($subtask['tanggal_aktual_akhir']) ?  date('d-m-Y H:i:s', strtotime( $subtask['tanggal_aktual_akhir'] )) : ''}}
                                </p>
                                <p>
                                    {{ $subtask['deskripsi_activity'] }}
                                </p>
                                @if(auth()->user()->role === 'manager')
                                    <a href="" data-project="{{ $project['id_proyek'] }}" data="{{ $subtask['id_activity'] }}" onclick="handleDeleteSubtask(this, event)">
                                        <i class="fa fa-trash" style="color:indianred"></i>
                                    </a>
                                    &nbsp;
                                @endif

                                @php
                                    $pieces = explode(',', $subtask['id_pegawai']);

                                @endphp

                                @if(in_array(auth()->user()->pegawai->id_pegawai, $pieces) || auth()->user()->role === 'manager')
                                    <a href="" data-project="{{ $project['id_proyek'] }}" data="{{ $subtask['id_activity'] }}" onclick="handleEditSubtask(this, event)">
                                        <i class="fa fa-pen" style="color:orange"></i>
                                    </a>
                                @endif

                                <br><br>
                                <p style="font-size:8pt;">
                                    @foreach($subtask['employee'] as $employee)
                                        <mark> {{ $employee}} </mark> &nbsp;
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="modal-create-task">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Tambah Task</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form onsubmit="handleSubmitTask(this,event)">
                    <div class="modal-body">
                        <input type="hidden" id="id_project" value="{{ $project['id_proyek'] }}">
                        <div class="form-group">
                            <label>Penanggung Jawab Task</label>
                            <select class="form-control id_employe_task" id="id_employe" name="id_employe[]" multiple="multiple">
                                @foreach($pegawai as $item)
                                    <option value="{{ $item->id_pegawai }}">{{ $item->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Label Task</label>
                            <input type="text" class="form-control" placeholder="nama task" id="label_task">
                        </div>

                        <div class="form-group">
                            <label>Deskripsi Task</label>
                            <input type="text" class="form-control" placeholder="nama task" id="description_task">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Plan Awal</label>
                            <input type="date" class="form-control" id="start_date_plan_task">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Plan Akhir</label>
                            <input type="date" class="form-control" id="end_date_plan_task">
                        </div>
                        <div class="form-group">
                            <label>Progress</label>
                            <input type="int" class="form-control" id="progress_task" disabled value="0">
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-edit-task">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Task</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form onsubmit="handleUpdateTask(this,event)">
                    <div class="modal-body">
                        <div id="appendDetailEditTask">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-create-subtask" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Subtask</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form onsubmit="handleSubmitSubtask(this,event)">
                    <div class="modal-body">
                        <div id="appendDetailCreateSubtask">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-edit-subtask">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Subtask</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form onsubmit="handleUpdateSubtask(this,event)">
                    <div class="modal-body">
                        <div id="appendDetailEditSubtask">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

    <script src="{{asset('app/build/tasks.js')}}"></script>
    <script src="{{asset('app/build/subtasks.js')}}"></script>
    <script src="{{asset('app/build/app.js')}}"></script>
@stop
