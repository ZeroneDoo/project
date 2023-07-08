@extends('main')

@section('title')
Baptis
@endsection

@section('content')
<div style="margin: 3rem auto; width: 91%">
    <div class="card">
        <div class="card-body">
            {{-- <div class="card-title">
                <a href="{{ route('baptis.create') }}" class="btn btn-primary">Tambah User</a>
            </div> --}}
            <div style="overflow: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal Baptis</th>
                            <th>Pendeta</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $i => $data)
                        <tr>
                            <td>{{ $i + $datas->FirstItem() }}</td>
                            <td>{{ $data->kkj_anak ? $data->kkj_anak->nama : $data->kkj_keluarga->nama }}</td>
                            <td>{{ Carbon\Carbon::parse($data->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</td>
                            <td>{{ $data->pendeta }}</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a href="{{ route('baptis.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('baptis.destroy', $data->id) }}" method="POST">
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