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
                    <h3>Daftar Pengeluaran</h3>
                </div>
                <div class="box-body">
                    <table id="deposit" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
						@foreach($expenses as $e)
                        <tr>
                            <td>{{ $e->id }}</td>
                            <td>{{ $e->expenseDate('d F Y') }}</td>
                            <td><span class="label label-{{ $e->category->color }}">{{ strtoupper($e->category->title) }}</span></td>
                            <td>{{ $e->description }}</td>
                            <td>{{ number_format($e->amount) }}</td>
                            <td><span class="label label-{{ $e->status == 'CLEARED' ? 'success' : 'warning' }}">{{ $e->status }}</span></td>
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
            $('#deposit').DataTable({
                "order": [[ 0, "desc" ]]
            });
        } );
    </script>
@endpush