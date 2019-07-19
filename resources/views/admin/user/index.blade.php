@extends('adminlte::page')

@section('title', 'Daftar User')

@section('content_header')
    <h1>User</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Daftar User</h3>
                </div>
                <div class="box-body">
                    <table id="user" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Registrasi</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
						@foreach($users as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->created_at }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                        </tr>
						@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(document).ready(function() {
            $('#user').DataTable();
        } );
    </script>
@endpush