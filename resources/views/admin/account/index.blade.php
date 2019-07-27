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
                    <h3>Semua Anggota <a class="btn btn-sm btn-add btn-info no-print" href="/admin/account/create"><i class="fa fa-plus"></i> Tambah anggota</a></h3>
                </div>
                <div class="box-body">
                    @if($print)
                    <div class="row print-only">
                        <div class="col-md-4">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td colspan="2">Keterangan :</td>
                                </tr>
                                <tr>
                                    <td width="50">Kabupaten/Kota</td>
                                    <td>: {{ $kabkot }}</td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td>: {{ $kecamatan }}</td>
                                </tr>
                                <tr>
                                    <td>Desa</td>
                                    <td>: {{ $desa }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>: {{ $status }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="row no-print">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="get" action="{{ Route('admin.account') }}">
                                <div class="form-group">
                                    <label for="kabkot" class="col-md-2 control-label">Kabupaten/Kota :</label>
                                    <div class="col-md-4">
                                        <select class="form-control select2-drop" id="kabkot" name="kabkot">
                                            <option value="ALL">Semua Kabupaten/Kota</option>
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
                                        <a href="{{ Route('admin.account') }}" style="margin-right: 10px;"> Reset</a>
                                        <button type="submit" class="btn btn-filter btn-primary" id="dtfilter"><i class="fa fa-sort"></i> Filter</button>
                                        <button type="submit" class="btn btn-print btn-info" name="print" value="1" onclick="$('form').attr('target', '_blank');"><i class="fa fa-print"></i> Print</button>
                                        <button type="submit" class="btn btn-export btn-success" name="export" value="1" onclick="$('form').attr('target', '_blank');"><i class="fa fa-file-excel-o"></i> Export XLS</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    @endif
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
                                    <th>Telepon</th>
                                    <th>TTL</th>
                                    <th>Alamat</th>
                                    <th class="no-print">Status</th>
                                    <th class="no-print"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($accounts as $k => $a)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $a->joined_at }}</td>
                                        <td>{{ $a->number }}</td>
                                        @if($print) <td>{{ $a->fullname }}</td>
                                        @else <td><a href="{{ url('/admin/account/' . $a->id) }}">{{ $a->fullname }}</a></td>
                                        @endif
                                        <td>{{ $a->jenis_kelamin() }}</td>
                                        <td>{{ $a->phone }}</td>
                                        <td>{{ $a->ttl('d F Y') }}</td>
                                        <td>{{ $a->address_full() }}</td>
                                        <td class="no-print"><span class="label label-{{ $a->status == 'ACTIVE' ? 'success' : 'default' }}">{{ $a->status }}</span></td>
                                        <td class="no-print">
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
    @if($print)
        <script>
            $(document).ready(function(){
               window.print();
            });
        </script>
    @else
        <script>
            $(document).ready(function() {
                $('#account').DataTable();

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
    @endif
@endpush