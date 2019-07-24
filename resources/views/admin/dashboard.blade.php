@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

<?php

function number_category($number){
    $text = number_format($number);
	if($number > 1000){
		$text = round($number / 1000, 2) . ' rb';
	}
	if($number > 1000000){
    	$text = round($number / 1000000, 2) . ' jt';
    }
    return $text;
}

?>

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $active_account }}/{{ $all_account }}</h3>

                    <p>Anggota Aktif</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="{{ Route('admin.account.create') }}" class="small-box-footer"><i class="fa fa-plus"></i> Registrasi Anggota baru</a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ sizeof($pending_account) }}/{{ $active_account }}<span style="color: white; font-size: 10pt;">anggota</span></h3>

                    <p>Belum membayar iuran</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ Route('admin.deposit.weekly') }}" class="small-box-footer">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><span style="color: white; font-size: 10pt;">Rp</span>{{ number_category($kas) }}</h3>

                    <p>Kas Tersimpan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ Route('admin.deposit.create') }}" class="small-box-footer"><i class="fa fa-calendar"></i> Buat Simpanan</a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><span style="color: white; font-size: 10pt;">Rp</span>{{ number_category($monthly_expense) }}</h3>

                    <p>Pengeluaran bulan ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ Route('admin.expense.create') }}" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i> Buat Pengeluaran</a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Anggota Baru</h3>
                </div>
                <div class="box-body">
                    <table id="account" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>J/K</th>
                            <th>Pekerjaan</th>
                            <th>Alamat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($new_account as $a)
                            <tr>
                                <td>{{ $a->joined_at }}</td>
                                <td><a href="{{ url('/admin/account/' . $a->id) }}">{{ $a->fullname }}</a></td>
                                <td>{{ $a->jenis_kelamin() }}</td>
                                <td>{{ $a->job }}</td>
                                <td>{{ $a->desa_full() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <a class="btn btn-default btn-block" href="{{ Route('admin.account') }}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Cashflow</h3>
                </div>
                <div class="box-body">
                    <canvas width="100%" height="50" id="cashflow-chart"></canvas>
                </div>
                <div class="box-footer">
                    <a class="btn btn-default btn-block" href="#">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Transaksi Terakhir</h3>
                </div>
                <div class="box-body">
                    <table id="deposit" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Aliran</th>
                            <th>Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($last_transaction as $d)
                            <tr>
                                <td>{{ $d->createdAt() }}</td>
                                <td><a href="{{ Route('admin.account.show', $d->account->id) }}" target="_blank">{{ $d->account->fullname }}</a></td>
                                <td>{{ $d->account->desa_full() }}</td>
                                <td><span class="text-{{ $d->flow == 'IN' ? 'green' : 'red' }}">{{ $d->flow }}</span></td>
                                <td><span class="text-{{ $d->flow == 'IN' ? 'green' : 'red' }}">{{ number_format($d->amount) }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <a class="btn btn-default btn-block" href="{{ Route('admin.deposit') }}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Pengeluaran Terkini</h3>
                </div>
                <div class="box-body">
                    <table id="deposit" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($last_expense as $e)
                            <tr>
                                <td>{{ $e->expenseDate('d F Y') }}</td>
                                <td><span class="label label-{{ $e->category->color }}">{{ strtoupper($e->category->title) }}</span></td>
                                <td>{{ $e->description }}</td>
                                <td>{{ number_format($e->amount) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <a class="btn btn-default btn-block" href="{{ Route('admin.expense') }}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(document).ready(function() {
            $('#pending-account').DataTable();
        } );

        var ctx = document.getElementById('cashflow-chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [{{ implode(',', $deposit_week) }}],
                datasets: [{
                    label: 'Iuran',
                    data: [{{ implode(',', $deposit_in) }}],
                    borderColor: 'rgb(0,149,81)',
                    backgroundColor: 'rgb(0,0,0,0)'
                },
                {
                    label: 'Penarikan',
                    data: [{{ implode(',', $deposit_out) }}],
                    borderColor: 'rgb(217,140,17)',
                    backgroundColor: 'rgb(0,0,0,0)'
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endpush