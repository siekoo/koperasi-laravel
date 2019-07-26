@extends('adminlte::page')

@section('title', 'Data anggota')

@section('content_header')
    <h1>Keanggotaan</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-10">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                    {{ session('success') }} Lihat detail anggota {{ isset($account) ? 'diperbarui' : 'baru' }} <a href="{{ url('admin/account/' . session('account_id')) }}"><strong>Disini</strong></a>
                </div>
            @elseif (session('failed'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Gagal!</h4>
                    Mohon hubungi administrator untuk perbaikan sistem. email admin <a href="mailto:{{ env('ADMIN_MAIL') }}"><strong>sekarang</strong></a>
                </div>
            @endif

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Data Anggota</h3>
                </div>
                <form class="form-horizontal" action="/admin/account/{{ isset($account) ? $account->id : '' }}" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="kartu_anggota" class="col-sm-3 control-label">Nomor Registrasi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="number" placeholder="" name="number" value="{{ isset($account) ? $account->number : $number }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="joined_at" class="col-sm-3 control-label">Tanggal Daftar</label>
                            <div class="col-sm-9">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right select-date" id="joined_at" name="joined_at" value="{{ isset($account) ? $account->joined_at : date('d/m/Y') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fullname" class="col-sm-3 control-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="fullname" placeholder="" name="fullname" value="{{ isset($account) ? $account->fullname : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="father_name" class="col-sm-3 control-label">Nama Ayah</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="father_name" placeholder="" name="father_name" value="{{  isset($account) ? $account->father_name : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grandfather_name" class="col-sm-3 control-label">Nama Kakek <small>(opsional)</small></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="grandfather_name" placeholder="" name="grandfather_name" value="{{ isset($account) ? $account->grandfather_name : '' }}">
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <label for="birth_place" class="col-sm-3 control-label">Tempat Lahir</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="birth_place" placeholder="" name="birth_place" value="{{ isset($account) ? $account->birth_place : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birth_date" class="col-sm-3 control-label">Tanggal Lahir</label>
                            <div class="col-sm-9">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right select-date" id="birth_date" name="birth_date" value="{{ isset($account) ? $account->birth_date() : '' }}" placeholder="dd/mm/yyyy" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="col-sm-3 control-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select type="text" class="form-control" id="gender" name="gender" required>
                                    <option value="M" {{ isset($account) && $account->gender == 'M' ? 'selected' : '' }}>Pria</option>
                                    <option value="F" {{ isset($account) && $account->gender == 'F' ? 'selected' : '' }}>Wanita</option>
                                </select>
                            </div>
                        </div>
                        <?php /*
                        <div class="form-group">
                            <label for="job" class="col-sm-3 control-label">Pekerjaan</label>
                            <div class="col-sm-9">
                                <select type="text" class="form-control select2-drop" id="job" name="job" required>
                                    <option value=""></option>
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->job }}" {{ isset($account) && $account->job == $job->job ? 'selected' : '' }}>{{ $job->job }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        */ ?>
                        <div class="form-group">
                            <label for="phone" class="col-sm-3 control-label">Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phone" placeholder="" name="phone" value="{{ isset($account) ? $account->phone : '' }}" required>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="birth_date" placeholder="" name="address" value="{{ isset($account) ? $account->address : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dusun" class="col-sm-3 control-label">Dusun <small>(opsional)</small></label>
                            <div class="col-sm-9">
                                <select class="select2-drop form-control" name="dusun" id="dusun">
                                    <option value=""></option>
                                    @foreach($dusuns as $dusun)
                                        <option value="{{ $dusun->dusun }}" {{ isset($account) && $account->dusun == $dusun->dusun ? 'selected' : '' }}>{{ $dusun->dusun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="village" class="col-sm-3 control-label">Desa</label>
                            <div class="col-sm-9">
                                <select type="text" class="form-control select-desa" id="desa" name="desa" required>
                                    <option value="{{ isset($account) ? $account->desa : '' }}" selected>{{ isset($account) ? $account->desa_full() : '' }}</option>
                                </select>
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
                        @if(isset($account))
                            <input name="_method" type="hidden" value="PUT">
                        @endif
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-info pull-right">{{ isset($account) ? 'Perbarui' : 'Simpan' }}</button>
                        <button type="button" class="btn btn-back btn-default">Batal</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .select2-drop{
            width: 100%;
        }
        .select-desa{
            width: 100%;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('.select-desa').select2({
                minimumInputLength: 2,
                ajax: {
                    url: '{{ url('/') . '/api/desa/' }}',
                    dataType: 'json',
                    data: function(params){
                        var query = {
                            keyword: params.term,
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.desa + ' KEC. ' + item.kecamatan + ', ' + item.kabkot,
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