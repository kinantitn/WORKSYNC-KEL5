@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Daftar Absensi</h1>
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
                                Absensi
                            </h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body row">
                            <table width="100%">
                                <thead>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->id_absensi }}</td>
                                        <td>{{ $item->employee->nama_lengkap }}</td>
                                        <td>{{ $item->employee->user->role }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->jam_masuk)) }}</td>
                                        <td>{{ date('H:i:s', strtotime($item->jam_masuk ))   }}</td>
                                        <td>{{ ($item->jam_keluar) ? date('H:i:s', strtotime($item->jam_keluar )) : '-'  }}</td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
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


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{asset('app/build/projects.js')}}"></script>
    <script src="{{asset('app/build/app.js')}}"></script>
    <script> console.log('Hi!'); </script>
@stop
