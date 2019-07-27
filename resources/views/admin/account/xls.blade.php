<table id="account" class="table table-striped table-bordered" style="width:100%">
    <thead>
    <tr>
        <th>No</th>
        <th>Pendaftaran</th>
        <th>Registrasi</th>
        <th>Nama Lengkap</th>
        <th>J/K</th>
        <th>Telepon</th>
        <th>TTL</th>
        <th>Alamat</th>
        <th class="no-print">Status</th>
        <th class="no-print"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($accounts as $k => $a)
        <tr>
            <td>{{ $k+1 }}</td>
            <td>{{ $a->joined_at }}</td>
            <td>{{ $a->number }}</td>
            @if($print) <td>{{ $a->fullname }}</td>
            @else <td><a href="{{ url('/admin/account/' . $a->id) }}">{{ $a->fullname }}</a></td>
            @endif
            <td>{{ $a->jenis_kelamin() }}</td>
            <td>{{ $a->phone }}</td>
            <td>{{ $a->ttl('d F Y') }}</td>
            <td>{{ $a->address_full() }}</td>
            <td class="no-print"><span class="label label-{{ $a->status == 'ACTIVE' ? 'success' : 'default' }}">{{ $a->status }}</span></td>
            <td class="no-print">
                <div class="btn-group-vertical">
                    <a class="btn btn-sm btn-edit btn-warning" href="{{ url('/admin/account/' . $a->id . '/edit') }}"><i class="fa fa-pencil"></i> Edit</a>
                    <form class="form" action="/admin/account/{{ $a->id }}" method="POST">
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