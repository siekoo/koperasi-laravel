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
                    <h3>Daftar Transaksi <a class="btn btn-sm btn-add btn-info" href="/admin/deposit/create"><i class="fa fa-plus"></i> Buat Transaksi</a></h3>
                </div>
                <div class="box-body">
                    <table id="deposit" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Registrasi</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Aliran</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
						@foreach($deposits as $d)
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->createdAt() }}</td>
                            <td>{{ $d->account->number }}</td>
                            <td><a href="{{ Route('admin.account.show', $d->account->id) }}" target="_blank">{{ $d->account->fullname }}</a></td>
                            <td>{{ $d->account->address_full() }}</td>
                            <td>{{ $d->account['phone'] }}</td>
                            <td><span class="text-{{ $d->flow == 'IN' ? 'green' : 'red' }}">{{ $d->flow }}</span></td>
                            <td><span class="text-{{ $d->flow == 'IN' ? 'green' : 'red' }}">IDR {{ number_format($d->amount) }}</span></td>
                            <td><span class="label label-{{ $d->status == 'CLEARED' ? 'success' : 'warning' }}">{{ $d->status }}</span></td>
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