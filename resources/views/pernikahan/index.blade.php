@extends('main')

@section('title')
Pernikahan
@endsection

@section('content')
<div style="margin: 3rem auto; width: 91%">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="{{ route('pernikahan.create') }}" class="btn btn-primary">Buat Pernikahan</a>
            </div>
            <div style="overflow: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pria</th>
                            <th>Nama Wanita</th>
                            <th>Waktu Pernikahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $i => $data)
                        <tr>
                            <td>{{ $i + $datas->FirstItem() }}</td>
                            <td>@foreach($data->pengantin as $pengantin_pria){{  $pengantin_pria->anggota_keluarga ? $pengantin_pria->anggota_keluarga->nama : ($pengantin_pria->jk == 'pria' ? $pengantin_pria->nama : '')}}@endforeach</td>
                            <td>@foreach($data->pengantin as $pengantin_wanita){{  $pengantin_wanita->anggota_keluarga ? $pengantin_wanita->anggota_keluarga->nama : ($pengantin_wanita->jk == 'wanita' ? $pengantin_wanita->nama : '')}}@endforeach</td>
                            <td>{{ Carbon\Carbon::parse($data->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a href="{{ route('pernikahan.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('pernikahan.destroy', $data->id) }}" method="POST">
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