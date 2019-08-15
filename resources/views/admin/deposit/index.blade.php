@extends('adminlte::page')

@section('title', 'Daftar Transaksi')

@section('content_header')
    <h1>Transaksi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Daftar Transaksi <a class="btn btn-sm btn-add btn-info no-print" href="/admin/deposit/create"><i class="fa fa-plus"></i> Buat Transaksi</a></h3>
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
                                        <td>: {{ \App\Kabkot::find($kabkot)->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>: {{ \App\Kecamatan::find($kecamatan)->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Rentang Data</td>
                                        <td>: {{ $startdate . ' s/d ' . $enddate }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                    <div class="row no-print">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="get" action="{{ Route('admin.deposit') }}">
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
                                    <label for="year" class="col-md-2 control-label">Tanggal Awal :</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input class="form-control hijri-picker" type="text" name="startdate" id="enddate" value="{{ isset($startdate) ? $startdate : 'ALL' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="year" class="col-md-2 control-label">Tanggal Akhir :</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input class="form-control hijri-picker" type="text" name="enddate" id="startdate" value="{{ isset($enddate) ? $enddate : 'ALL' }}">
                                        </div>
                                    </div>
                                </div>
                                <?php /*
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
                                */ ?>
                                <div class="form-group">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <a href="{{ Route('admin.deposit') }}" style="margin-right: 10px;"> Reset</a>
                                        <button type="submit" class="btn btn-filter btn-primary" id="dtfilter"><i class="fa fa-sort"></i> Filter</button>
                                        <button type="submit" class="btn btn-print btn-info" name="print" value="1" onclick="$('form').attr('target', '_blank');"><i class="fa fa-print"></i> Print</button>
                                        <button type="submit" class="btn btn-export btn-success" name="export" value="1" onclick="$('form').attr('target', '_blank');"><i class="fa fa-file-excel-o"></i> Export XLS</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <table id="deposit" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Registrasi</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kabkot</th>
                                <th>Telepon</th>
                                <th>Aliran</th>

                                <th>Jumlah</th>
                                @if(!$print)<th></th>@endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deposits as $k => $d)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ GeniusTS\HijriDate\Hijri::convertToHijri($d->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $d->number }}</td>
                                    @if($print) <td>{{ $d->fullname }}</td>
                                    @else <td><a href="{{ Route('admin.account.show', $d->account_id) }}" target="_blank">{{ $d->fullname }}</a></td>
                                    @endif
                                    <td>{{ $d->address . ', ' . $d->dusun}}<br>{{ 'Kec. ' . ucfirst(strtolower(\App\Kecamatan::find($d->kecamatan)->nama)) }}</td>
                                    <td>{{ \App\Kabkot::find($d->kabkot)->nama }}</td>
                                    <td>{{ $d->phone }}</td>
                                    <td><span class="text-{{ $d->flow == 'IN' ? 'green' : 'red' }}">{{ $d->flow }}</span></td>
                                    <td><span class="text-{{ $d->flow == 'IN' ? 'green' : 'red' }}">IDR {{ number_format($d->amount) }}</span></td>
                                   <?php /* <td><span class="label label-{{ $d->status == 'CLEARED' ? 'success' : 'warning' }}">{{ $d->status }}</span></td> */ ?>
                                    @if(!$print)
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a class="btn btn-sm btn-edit btn-warning" href="{{ url('/admin/deposit/' . $d->id . '/edit') }}"><i class="fa fa-pencil"></i> Edit</a>
                                            <form class="form" action="/admin/deposit/{{ $d->id }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="delete">
                                                <button type="submit" class="btn btn-sm btn-delete btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/jquery.calendars/css/jquery.calendars.picker.css') }}"/>
@endpush

@push('js')
    @if($print)
        <script>
            $(document).ready(function(){
                window.print();
            });
        </script>
    @else
        <script src="{{ asset('vendor/jquery.calendars/js/jquery.calendars.js') }}"></script>
        <script src="{{ asset('vendor/jquery.calendars/js/jquery.calendars.plus.js') }}"></script>
        <script src="{{ asset('vendor/jquery.calendars/js/jquery.plugin.js') }}"></script>
        <script src="{{ asset('vendor/jquery.calendars/js/jquery.calendars.picker.js') }}"></script>
        <script src="{{ asset('vendor/jquery.calendars/js/jquery.calendars.islamic.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#deposit').DataTable({
                    "order": [[ 0, "asc" ]]
                });

                $('.hijri-picker').calendarsPicker({
                    calendar: $.calendars.instance('islamic'),
                    dateFormat: 'dd-mm-yyyy'
                });

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