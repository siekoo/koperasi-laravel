@extends('adminlte::page')

@section('title', 'Daftar Anggota')

@section('content_header')
    <h1>Keanggotaan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Semua Anggota <a class="btn btn-sm btn-add btn-info" href="/admin/account/create"><i class="fa fa-plus"></i> Tambah anggota</a></h3>
                </div>
                <div class="box-body">
                    <table id="account" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Pendaftaran</th>
                            <th>Rekening</th>
                            <th>Nama Lengkap</th>
                            <th>J/K</th>
                            <th>Pekerjaan</th>
                            <th>Telepon</th>
                            <th>TTL</th>
                            <th>Alamat</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
						@foreach($account as $a)
                        <tr>
                            <td>{{ $a->id }}</td>
                            <td>{{ $a->joined_at }}</td>
                            <td>{{ $a->number }}</td>
                            <td>{{ $a->fullname }}</td>
                            <td>{{ $a->jenis_kelamin() }}</td>
                            <td>{{ $a->job }}</td>
                            <td>{{ $a->phone }}</td>
                            <td>{{ $a->ttl('d F Y') }}</td>
                            <td>{{ $a->address_full() }}</td>
                            <td>
                                <div class="btn-group-vertical">
                                    <a class="btn btn-sm btn-show btn-info" href="{{ url('/admin/account/' . $a->id) }}"><i class="fa fa-window-maximize"></i> Detail</a>
                                    <a class="btn btn-sm btn-edit btn-warning" href="{{ url('/admin/account/' . $a->id . '/edit') }}"><i class="fa fa-pencil"></i> Edit</a>
                                    <form class="form" action="/admin/account/{{ $a->id }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <button type="submit" class="btn btn-sm btn-delete btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </td>
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
            $('#account').DataTable();
        } );
    </script>
@endpush