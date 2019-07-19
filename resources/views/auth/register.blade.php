@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Administrasi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Registrasi user baru</h3>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="fullname" class="col-sm-3 control-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                           placeholder="Nama lengkap">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                           placeholder="Email user">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="amount" class="col-sm-3 control-label">Konfirmasi Password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password_confirmation" class="form-control"
                                           placeholder="ulangi password">
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-info pull-right">Simpan</button>
                            <button type="button" class="btn btn-back btn-default">Batal</button>
                        </div>

                    </form>
                </div>
                <!-- /.form-box -->
            </div><!-- /.register-box -->
        </div>
    </div>
@stop