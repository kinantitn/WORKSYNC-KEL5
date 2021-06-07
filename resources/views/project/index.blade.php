@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Daftar Proyek</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    @if(auth()->user()->role == 'manager')
                                    <button class="btn btn-primary" type="button" onclick="handleCreateProject(this,event)">
                                        <i class="fa fa-plus"></i>
                                        Tambah Proyek
                                    </button>
                                    @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body row">
                                <div class="col-md-12">
                                    <canvas id="myChart3"></canvas>
                                </div>
                                <div class="col-md-12">&nbsp;</div>
                                @foreach($data as $item)
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box bg-gradient-lightblue" >
                                        <span class="info-box-icon"><i class="fa fa-tasks"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ $item['nama_proyek'] }}</span>
                                            <span class="info-box-number">{{ $item['duration'] }} Hari</span>
                                            <span class="info-box-text">{{ $item['status'] }}</span>

                                            <div class="progress">
                                                &nbsp;
                                            </div>
                                            <span class="progress-description">
                                                <a href="{{ url('project/'. $item['id_proyek'] ) }}" class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if(auth()->user()->role === 'manager')
                                                <a href=""  data="{{ $item['id_proyek'] }}" onclick="handleEditProject(this,event)"  class="btn btn-warning btn-sm">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                                <a href=""  data="{{ $item['id_proyek'] }}" onclick="handleDeleteProject(this,event)"  class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col-md-6 -->

                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>




        <div class="modal fade" id="modal-create-project">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Proyek</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form onsubmit="handleSubmitProjects(this,event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Proyek</label>
                                <input type="text" class="form-control" placeholder="nama proyek" id="name">
                            </div>
                            <div class="form-group">
                                <label>Penanggung Jawab Proyek</label>
                                <select class="form-control id_employe_project" id="id_employe" name="id_employe[]" multiple="multiple">
                                    @foreach($pegawai as $item)
                                        <option value="{{ $item->id_pegawai }}">{{ $item->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Plan Awal</label>
                                <input type="date" class="form-control" id="start_date_plan">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Plan Akhir</label>
                                <input type="date" class="form-control" id="end_date_plan">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" id="status">
                                    <option>New</option>
                                    <option>In Progress</option>
                                    <option>Done</option>
                                </select>
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


        <div class="modal fade" id="modal-edit-project">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Proyek</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form onsubmit="handleUpdateProject(this,event)">
                    <div class="modal-body">
                        <div id="appendProjectDetail">

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
    <script src="{{asset('app/build/projects.js')}}"></script>
    <script src="{{asset('app/build/app.js')}}"></script>
    <script> console.log('Hi!'); </script>
@stop
