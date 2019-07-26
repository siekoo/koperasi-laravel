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
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="get" action="{{ Route('admin.account') }}">
                                <div class="form-group">
                                    <label for="kabkot" class="col-md-2 control-label">Kabupaten/Kota :</label>
                                    <div class="col-md-4">
                                        <select class="form-control select2-drop" id="kabkot" name="kabkot">
                                            <option value="all">Semua Kabupaten/Kota</option>
                                            @foreach($kabkot_data as $k)
                                                <option value="{{ $k->id }}" {{ $k->id == $kabkot ? 'selected' : '' }}>{{ $k->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kecamatan" class="col-md-2 control-label">Kecamatan :</label>
                                    <div class="col-md-4">
                                        <select class="form-control select-kecamatan" id="kecamatan" name="kecamatan">
                                            @if(isset($kecamatan_data))
                                            <option value="{{ $kecamatan_data->id }}">{{ $kecamatan_data->nama }}</option>
                                            @else
                                            <option value="ALL">Semua Kecamatan</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="desa" class="col-md-2 control-label">Desa :</label>
                                    <div class="col-md-4">
                                        <select class="form-control select-desa" id="desa" name="desa">
                                            @if(isset($desa_data))
                                            <option value="{{ $desa_data->id }}">{{ $desa_data->nama }}</option>
                                            @else
                                            <option value="ALL">Semua Desa</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-md-2 control-label">Status :</label>
                                    <div class="col-md-4">
                                        <select class="form-control" id="dtstatus" name="status">
                                            @foreach($status_data as $s)
                                                <option value="{{ $s }}" {{ $s == $status ? 'selected' : ''}}>{{ $s }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <a href="{{ Route('admin.account') }}" style="margin-right: 20px;"> Reset</a>
                                        <button type="submit" class="btn btn-filter btn-primary" id="dtfilter"><i class="fa fa-sort"></i> Filter</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="account" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pendaftaran</th>
                                    <th>Registrasi</th>
                                    <th>Nama Lengkap</th>
                                    <th>J/K</th>
                                    <th>Pekerjaan</th>
                                    <th>Telepon</th>
                                    <th>TTL</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($accounts as $a)
                                    <tr>
                                        <td>{{ $a->id }}</td>
                                        <td>{{ $a->joined_at }}</td>
                                        <td>{{ $a->number }}</td>
                                        <td><a href="{{ url('/admin/account/' . $a->id) }}">{{ $a->fullname }}</a></td>
                                        <td>{{ $a->jenis_kelamin() }}</td>
                                        <td>{{ $a->job }}</td>
                                        <td>{{ $a->phone }}</td>
                                        <td>{{ $a->ttl('d F Y') }}</td>
                                        <td>{{ $a->address_full() }}</td>
                                        <td><span class="label label-{{ $a->status == 'ACTIVE' ? 'success' : 'default' }}">{{ $a->status }}</span></td>
                                        <td>
                                            <div class="btn-group-vertical">
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
        </div>
    </div>
@stop

@push('js')
    <script>
        console.log('kabkot : ' + $('#kabkot').val());
        console.log('kecamatan : ' + $('#kecamatan').val());

        $(document).ready(function() {
            $('#account').DataTable({
                "order": [[ 3, "asc" ]]
            });
        } );

        $(document).ready(function() {

            $('.select-kecamatan').select2({
                placeholder: '',
                allowClear: true,
                ajax: {
                    url: '{{ url('/') . '/api/kecamatan' }}',
                    dataType: 'json',
                    data: function(params){
                        var query = {
                            keyword: params.term,
                            kabkot: $('#kabkot').val()
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.nama,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });

            $('.select-desa').select2({
                placeholder: '',
                allowClear: true,
                ajax: {
                    url: '{{ url('/') . '/api/desa' }}',
                    dataType: 'json',
                    data: function(params){
                        var query = {
                            keyword: params.term,
                            kabkot: $('#kabkot').val(),
                            kecamatan: $('#kecamatan').val()
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.desa,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
        });

    </script>
@endpush