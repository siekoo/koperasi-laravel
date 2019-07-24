@extends('adminlte::page')

@section('title', 'Data Pengeluaran')

@section('content_header')
    <h1>Pengeluaran</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-10">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                    {{ session('success') }}
                </div>
            @endif

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Data Pengeluaran</h3>
                </div>
                <form class="form-horizontal" action="/admin/expense/{{ isset($expense) ? $expense->id : '' }}" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="joined_at" class="col-sm-3 control-label">Tanggal</label>
                            <div class="col-sm-9">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right select-date" value="{{ isset($expense) ? $expense->expense_date() : date('d/m/Y') }}" id="expense_date" name="expense_date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="expense_category_id" class="col-sm-3 control-label">Kategori</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="expense_category_id" name="expense_category_id" required>
                                    <option value=""></option>
                                    @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ isset($expense) && $expense->expense_category_id == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Deskripsi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="{{ isset($expense) ? $expense->description : '' }}" name="description" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-sm-3 control-label">Jumlah (Rp)</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="amount" name="amount" value="{{ isset($expense) ? $expense->amount : '' }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="status" name="status" required>
                                    <option value="CLEARED" {{ isset($expense) && $expense->status == 'CLEARED' ? 'selected' : '' }}>CLEARED</option>
                                    <option value="PENDING" {{ isset($expense) && $expense->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
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
                        @if(isset($expense))
                            <input name="_method" type="hidden" value="PUT">
                        @endif
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-info pull-right">Simpan</button>
                        <button type="button" class="btn btn-back btn-default">Batal</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop