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
                    <li class="breadcrumb-item"><a href="#">Layout</a></li>
                    <li class="breadcrumb-item active">Top Navigation</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
{{--    <div class="content">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-12">--}}
{{--                    <div class="card card-default">--}}
{{--                        <div class="card-header">--}}
{{--                            <h3 class="card-title">--}}
{{--                                <button class="btn btn-primary">--}}
{{--                                    <i class="fa fa-plus"></i>--}}
{{--                                    Tambah Proyek--}}
{{--                                </button>--}}
{{--                            </h3>--}}
{{--                        </div>--}}
{{--                        <!-- /.card-header -->--}}
{{--                        <div class="card-body row">--}}
{{--                            <div class="col-md-3 col-sm-6 col-12">--}}
{{--                                <div class="info-box" style="background-color: #00cd5a;">--}}
{{--                                    <span class="info-box-icon"><i class="fa fa-tasks"></i></span>--}}

{{--                                    <div class="info-box-content">--}}
{{--                                        <span class="info-box-text">Nama Proyek</span>--}}
{{--                                        <span class="info-box-number">41,410</span>--}}

{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar" style="width: 70%"></div>--}}
{{--                                        </div>--}}
{{--                                        <span class="progress-description">--}}
{{--                                            <a href="" class="btn btn-info btn-sm">--}}
{{--                                                <i class="fa fa-eye"></i>--}}
{{--                                            </a>--}}
{{--                                            <a href="" class="btn btn-warning btn-sm">--}}
{{--                                                <i class="fa fa-pen"></i>--}}
{{--                                            </a>--}}
{{--                                            <a href="" class="btn btn-danger btn-sm">--}}
{{--                                                <i class="fa fa-trash"></i>--}}
{{--                                            </a>--}}
{{--                                        </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-3 col-sm-6 col-12">--}}
{{--                                <div class="info-box" style="background-color: #00cd5a;">--}}
{{--                                    <span class="info-box-icon"><i class="fa fa-tasks"></i></span>--}}

{{--                                    <div class="info-box-content">--}}
{{--                                        <span class="info-box-text">Nama Proyek</span>--}}
{{--                                        <span class="info-box-number">41,410</span>--}}

{{--                                        <div class="progress">--}}
{{--                                            <div class="progress-bar" style="width: 70%"></div>--}}
{{--                                        </div>--}}
{{--                                        <span class="progress-description">--}}
{{--                                            <a href="" class="btn btn-info btn-sm">--}}
{{--                                                <i class="fa fa-eye"></i>--}}
{{--                                            </a>--}}
{{--                                            <a href="" class="btn btn-warning btn-sm">--}}
{{--                                                <i class="fa fa-pen"></i>--}}
{{--                                            </a>--}}
{{--                                            <a href="" class="btn btn-danger btn-sm">--}}
{{--                                                <i class="fa fa-trash"></i>--}}
{{--                                            </a>--}}
{{--                                        </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <!-- /.card-body -->--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- /.col-md-6 -->--}}

{{--                <!-- /.col-md-6 -->--}}
{{--            </div>--}}
{{--            <!-- /.row -->--}}
{{--        </div><!-- /.container-fluid -->--}}
{{--    </div>--}}



    <!-- Content Wrapper. Contains page content -->
    <div class="row">

        <div class="col-md-3">
            <div class="card card-row card-secondary">
                <div class="card-header">
{{--                    <h3 class="card-title">--}}

                        <button class="btn btn-primary pull-right" style="float: right">
                            <i class="fa fa-plus"></i>
                            Task
                        </button>
{{--                    </h3>--}}
                </div>
                <div class="card-body">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Create PR template</h5>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-link">#6</a>
                                <a href="#" class="btn btn-tool">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card card-light card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Create Actions</h5>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-link">#7</a>
                                <a href="#" class="btn btn-tool">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                Aenean commodo ligula eget dolor. Aenean massa.
                                Cum sociis natoque penatibus et magnis dis parturient montes,
                                nascetur ridiculus mus.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-row card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        To Do
                    </h3>
                </div>
                <div class="card-body">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Create PR template</h5>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-link">#6</a>
                                <a href="#" class="btn btn-tool">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card card-light card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Create Actions</h5>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-link">#7</a>
                                <a href="#" class="btn btn-tool">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                Aenean commodo ligula eget dolor. Aenean massa.
                                Cum sociis natoque penatibus et magnis dis parturient montes,
                                nascetur ridiculus mus.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-row card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        To Do
                    </h3>
                </div>
                <div class="card-body">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Create PR template</h5>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-link">#6</a>
                                <a href="#" class="btn btn-tool">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card card-light card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Create Actions</h5>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-link">#7</a>
                                <a href="#" class="btn btn-tool">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                Aenean commodo ligula eget dolor. Aenean massa.
                                Cum sociis natoque penatibus et magnis dis parturient montes,
                                nascetur ridiculus mus.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-row card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        To Do
                    </h3>
                </div>
                <div class="card-body">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Create PR template</h5>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-link">#6</a>
                                <a href="#" class="btn btn-tool">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card card-light card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Create Actions</h5>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-link">#7</a>
                                <a href="#" class="btn btn-tool">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                Aenean commodo ligula eget dolor. Aenean massa.
                                Cum sociis natoque penatibus et magnis dis parturient montes,
                                nascetur ridiculus mus.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
