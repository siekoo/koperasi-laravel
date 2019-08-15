@extends('adminlte::page')

@section('title', 'Iuran Wajib')

@section('content_header')
    <h1>Iuran Wajib</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3>Daftar Anggota Belum Iuran</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td width="100">Rentang data</td>
                                    <td>: {{ $startdate }} s/d {{ $enddate }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="pending-account" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <th>No</th>
                                <th>Registrasi</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kecamatan</th>
                                <th>Kabkot</th>
                                <th>Kontak</th>
                                <th></th>
                                </thead>
                                <tbody>
                                @foreach($account_payment as $k => $p)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $p->number }}</td>
                                        <td><a href="{{ Route('admin.account.show', $p->id) }}">{{ $p->fullname }}</a></td>
                                        <td>{{ $p->address }}, {{ $p->dusun }}</td>
                                        <td>{{ \App\Kecamatan::find($p->kecamatan)->nama }}</td>
                                        <td>{{ \App\Kabkot::find($p->kabkot)->nama }}</td>
                                        <td><a href="http://wa.me/{{ $p->phone }}" target="_blank"><i class="fa fa-whatsapp"></i> {{ $p->phone }}</a></td>
                                        <?php /* <td><span class="label label-{{ $p->weekly_payment == 'paid' ? 'success' : 'warning' }}">{{ strtoupper($p->weekly_payment) }}</span></td> */ ?>
                                        <td>@if($p->weekly_payment == 'pending')<a class="btn btn-primary" href="{{ Route('admin.deposit.create', array('number' => $p->number)) }}"><i class="fa fa-pencil"></i> Isi Iuran</a>@endif</td>
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

@push('css')
    <style>
        #pending-account_length{
            display: inline !important;
        }
        #custom-filter > select{
            margin-left: 5px;
            width: 80px;
        }
        .btn-filter {
            margin-left: 5px;
        }
    </style>
@endpush

@push('js')
    <script>
        var action = '{{ Route('admin.deposit.weekly') }}';
        $(document).ready(function() {
            $('#pending-account').DataTable({
                "order": [[ 2, "asc" ]]
            });
            <?php /*
            $('<div id="custom-filter" style="display: inline; margin-left: 15px;">Pekan : ' +
                '<select class="form-control" id="dtweek" name="week"></select>' +
                '<select class="form-control" id="dtyear" name="year"></select>' +
                '<select class="form-control" id="dtstatus">' +
                '<option value="all">Semua</option>' +
                '<option value="paid">Lunas</option>' +
                '<option value="pending">Belum lunas</option>' +
                '</select>' +
                '<button class="btn btn-filter btn-primary" id="dtfilter">Filter</button>' +
            '</div>').appendTo("#pending-account_wrapper > .row:first > .col-sm-6:first");
            for(var i = 1; i <= 52; i++){
                $('#dtweek').append($('<option>', {
                    value: i,
                    text : i
                }));
            }
            for(var i = 2019; i <= (new Date).getFullYear(); i++){
                $('#dtyear').append($('<option>', {
                    value: i,
                    text : i
                }));
            }
            $('#dtweek').val({{ $week }});
            $('#dtyear').val({{ $year }});
            $('#dtstatus').val('{{ $status }}');

            $('#dtfilter').click(function(){
                window.location.href = action + '?year=' + $('#dtyear').val() + '&week=' + $('#dtweek').val() + '&status=' + $('#dtstatus').val();
            })
            */ ?>
        } );

    </script>
@endpush