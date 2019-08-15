@extends('adminlte::page')

@section('title', 'Daftar Pengeluaran')

@section('content_header')
    <h1>Pengeluaran</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                    {{ session('success') }}
                </div>
            @endif

            <div class="box box-info">
                <div class="box-header">
                    <h3>Daftar Pengeluaran <a class="btn btn-sm btn-add btn-info no-print" href="/admin/expense/create"><i class="fa fa-plus"></i> Buat Pengeluaran</a></h3>
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
                                        <td width="50">Kategori</td>
                                        <td>: {{ $category }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>: {{ $status }}</td>
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
                                <form class="form-horizontal" method="get" action="{{ Route('admin.expense') }}">
                                    <div class="form-group">
                                        <label for="kabkot" class="col-md-2 control-label">Kategori :</label>
                                        <div class="col-md-4">
                                            <select class="form-control select2-drop" id="category" name="category">
                                                <option value="ALL">Semua Kategori</option>
                                                @foreach($category_data as $c)
                                                    <option value="{{ $c->id }}" {{ $c->id == $category ? 'selected' : '' }}>{{ $c->title }}</option>
                                                @endforeach
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
                                            <a href="{{ Route('admin.expense') }}" style="margin-right: 10px;"> Reset</a>
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
                        <table id="expense" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Admin</th>
                                @if(!$print)<th></th>@endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($expenses as $k => $e)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $e->expenseDate() }}</td>
                                    <td>{{ strtoupper($e->category->title) }}</td>
                                    <td>{{ $e->description }}</td>
                                    <td style="text-align: right;">{{ number_format($e->amount) }}</td>
                                    @if($print) <td>{{ $e->status }}</td>
                                    @else <td style="text-align: center;"><span class="label label-{{ $e->status == 'CLEARED' ? 'success' : 'warning' }}">{{ $e->status }}</span></td>
                                    @endif
                                    <td>{{ $e->user()->name }}</td>
                                    @if(!$print)
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a class="btn btn-sm btn-edit btn-warning" href="{{ url('/admin/expense/' . $e->id . '/edit') }}"><i class="fa fa-pencil"></i> Edit</a>
                                            <form class="form" action="/admin/expense/{{ $e->id }}" method="POST">
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
                $('#expense').DataTable({
                    "order": [[ 0, "asc" ]]
                });

                $('.hijri-picker').calendarsPicker({
                    calendar: $.calendars.instance('islamic'),
                    dateFormat: 'dd-mm-yyyy'
                });
            });

        </script>
    @endif
@endpush