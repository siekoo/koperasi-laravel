<?php use App\User; ?>

@extends('adminlte::page')

@section('title', 'Detail Anggota')

@section('content_header')
    <h1>Keanggotaan</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-10">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Data Anggota <a class="btn btn-sm btn-add btn-info" href="/admin/account/{{ $account->id }}/edit"><i class="fa fa-pencil"></i> Edit</a></h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>No Registrasi</td>
                                <td>{{ $account->number }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Pendaftaran</td>
                                <td>{{ $account->joined_at('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>{{ $account->fullname }}</td>
                            </tr>
                            <tr>
                                <td>TTL</td>
                                <td>{{ $account->ttl('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>{{ $account->jenis_kelamin() }}</td>
                            </tr>
                            <?php /*
                            <tr>
                                <td>Pekerjaan</td>
                                <td>{{ $account->job }}</td>
                            </tr>
                            */ ?>
                            <tr>
                                <td>Telepon</td>
                                <td>{{ $account->phone }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>{{ $account->address_full() }}</td>
                            </tr>
                            <tr>
                                <td>Deposito</td>
                                <td>IDR {{ number_format($account->balance()) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Riwayat Transaksi</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table" id="mutasi">
                        <thead>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pekan</th>
                            <th>Aliran</th>
                            <th>Jumlah</th>
                            <th>Kasir</th>
                        </thead>
                        <tbody>
                            @foreach($transaction as $k => $t)
                            <tr>
                                <td>{{ ($k+1) }}</td>
                                <td>{{ $t->createdAt() }}</td>
                                <td>{{ $t->createdAt('W') }}</td>
                                <td><span class="text-{{ $t->flow == 'IN' ? 'green' : 'red' }}">{{ $t->flow }}</span></td>
                                <td><span class="text-{{ $t->flow == 'IN' ? 'green' : 'red' }}">IDR {{ number_format($t->amount) }}</span></td>
                                <td>{{ User::find($t->user_id)['name'] }}</td>
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
        $('#mutasi').DataTable({
            "order": [[ 0, "asc" ]]
        });
    </script>

@endpush
