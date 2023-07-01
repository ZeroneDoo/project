@extends('main')

@section('title')
    Kartu Keluarga Jemaat
@endsection

@section('content')
<div style="margin: 3rem auto; width: 91%">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="{{ route('kkj.create') }}" class="btn btn-primary">Tambah KKJ</a>
            </div>
            <div style="overflow: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th style="min-width: 200px">Nama Kepala Keluarga</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $i => $data)
                        <tr>
                            <td>{{ $i + $datas->FirstItem() }}</td>
                            <td>{{ $data->kode }}</td>
                            <td>{{ $data->nama_kepala_keluarga }}</td>
                            <td>{{ $data->email }}</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a href="{{ route('kkj.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('kkj.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 0.75rem; width: 100%">
                {{ $datas->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
