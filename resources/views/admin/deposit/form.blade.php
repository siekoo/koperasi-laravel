@extends('adminlte::page')

@section('title', 'Data Simpanan')

@section('content_header')
    <h1>Simpanan</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-10">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                    {{ session('success') }} Lihat mutasi transaksi <a href="{{ url('admin/account/' . session('account_id')) }}"><strong>Disini</strong></a>
                </div>
            @endif

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Simpanan</h3>
                </div>
                <form class="form-horizontal" action="/admin/deposit/" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="joined_at" class="col-sm-3 control-label">Tanggal Simpanan</label>
                            <div class="col-sm-9">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right select-date" id="joined_at" name="joined_at" value="{{ date('d/m/Y') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kartu_anggota" class="col-sm-3 control-label">Nomor Registrasi</label>
                            <div class="col-sm-9">
                                <select class="form-control select-rekening" id="account" name="account" required>
                                    @if(isset($account))
                                    <option value="{{ $account->id }}" selected>{{ $account->number . ' - ' . $account->fullname }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fullname" class="col-sm-3 control-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="fullname" value="" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" value="" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-3 control-label">Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phone" value="" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fullname" class="col-sm-3 control-label">Jenis</label>
                            <div class="col-sm-9">
                                <select type="text" class="form-control" id="flow" name="flow" required>
                                    <option value="IN">Setoran</option>
                                    <option value="OUT">Penarikan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-sm-3 control-label">Jumlah (Rp)</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="amount" name="amount" value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="_confirm" value="true" required> Saya yakin semua data diatas sudah benar
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-info pull-right">Simpan</button>
                        <button type="button" class="btn btn-back btn-default">Batal</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .select-rekening{
            width: 100%;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('.select-rekening').select2({
                minimumInputLength: 10,
                ajax: {
                    url: '{{ url('/') . '/api/rekening/' }}',
                    dataType: 'json',
                    data: function(params){
                        var query = {
                            number: params.term,
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                                $('#fullname').val(item.fullname);
                                $('#phone').val(item.phone);
                                $('#address').val(item.address);
                                return {
                                    text: item.number + ' - ' + item.fullname,
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