@extends('adminlte::page')

@section('title', 'Daftar Simpanan')

@section('content_header')
    <h1>Simpanan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Daftar Simpanan</h3>
                </div>
                <div class="box-body">
                    <table id="deposit" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nomor Rekening</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Aliran</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
						@foreach($deposits as $d)
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->created_at }}</td>
                            <td>{{ $d->account['number'] }}</td>
                            <td>{{ $d->account['fullname'] }}</td>
                            <td>{{ $d->account->address_full() }}</td>
                            <td>{{ $d->account['phone'] }}</td>
                            <td><span class="text-{{ $d->flow == 'IN' ? 'green' : 'red' }}">{{ $d->flow }}</span></td>
                            <td><span class="text-{{ $d->flow == 'IN' ? 'green' : 'red' }}">IDR {{ number_format($d->amount) }}</span></td>
                            <td>{{ $d->status }}</td>
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
            $('#deposit').DataTable();
        } );
    </script>
@endpush