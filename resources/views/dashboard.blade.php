@extends('main')

@section('content')
<div class="p-4">
    <h1>dashboard {{ Auth::user()->role->nama }}</h1>
    @if (Auth::user()->role->nama == "Super Admin")
        <a href="{{ route('role.index') }}" class="btn btn-primary">Pergi ke halaman role</a>
        <a href="{{ route('user.index') }}" class="btn btn-primary">Pergi ke halaman user</a>
        <a href="{{ route('pendeta.index') }}" class="btn btn-primary">Pergi ke halaman pendeta</a>
    
    @elseif(Auth::user()->role->nama == "Admin Baptis")
        <a href="{{ route('baptis.index') }}" class="btn btn-primary">Pergi ke halaman baptis</a>
        <div class="card mt-3 p-3">
            <div class="card-title">
                <h2>Status Waiting</h2>
            </div>
            <div class="card-body">
                <div style="overflow: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal Baptis</th>
                                <th>Pendeta</th>
                                <th>Foto</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $i => $data)
                            <tr>
                                <td>{{ $i + $datas->FirstItem() }}</td>
                                <td>{{ $data->anggota_keluarga->nama }}</td>
                                <td>{{ Carbon\Carbon::parse($data->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</td>
                                <td>{{ $data->pendeta ? $data->pendeta->namaa  : ""}}</td>
                                <td><img src="{{ asset('storage/'.$data->foto) }}" style="width: 200px; height: 100px;object-fit: cover" alt=""></td>
                                <td><span class="p-1 btn btn-warning" style="color:white;">{{ $data->status }}</span></td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('handler.baptis.show', $data->id) }}" class="btn btn-info">Detail</a>
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
    @elseif(Auth::user()->role->nama == "Admin Penyerahan")
        <a href="{{ route('penyerahan.index') }}" class="btn btn-primary">Pergi ke halaman penyerahan</a>
        
        <div class="card mt-3 p-3">
            <div class="card-title">
                <h2>Status Waiting</h2>
            </div>
            <div class="card-body">
                <div style="overflow: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal Penyerahan</th>
                                <th>Pendeta</th>
                                <th>Foto</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $i => $data)
                            <tr>
                                <td>{{ $i + $datas->FirstItem() }}</td>
                                <td>{{ $data->anggota_keluarga->nama }}</td>
                                <td>{{ Carbon\Carbon::parse($data->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</td>
                                <td>{{ $data->pendeta ? $data->pendeta->namaa  : ""}}</td>
                                <td><img src="{{ asset('storage/'.$data->foto) }}" style="width: 100px; object-fit: cover" alt=""></td>
                                <td><span class="p-1 btn btn-warning" style="color:white;">{{ $data->status }}</span></td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('handler.penyerahan.show', $data->id) }}" class="btn btn-info">Detail</a>
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
    @elseif(Auth::user()->role->nama == "Admin Pernikahan")
        <a href="{{ route('pernikahan.index') }}" class="btn btn-primary">Pergi ke halaman pernikahan</a>
    
        <div class="card mt-3 p-3">
            <div class="card-title">
                <h2>Status Waiting</h2>
            </div>
            <div class="card-body">
                <div style="overflow: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pria</th>
                                <th>Nama Wanita</th>
                                <th>Waktu Pernikahan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $i => $data)
                            <tr>
                                <td>{{ $i + $datas->FirstItem() }}</td>
                                <td>{{ $data->pengantin->where("jk", "pria")->last()->anggota_keluarga ? $data->pengantin->where("jk", "pria")->last()->anggota_keluarga->nama : $data->pengantin->where("jk", "pria")->last()->nama }}</td>
                                <td>{{ $data->pengantin->where("jk", "wanita")->last()->anggota_keluarga ? $data->pengantin->where("jk", "wanita")->last()->anggota_keluarga->nama : $data->pengantin->where("jk", "wanita")->last()->nama }}</td>
                                <td>{{ Carbon\Carbon::parse($data->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</td>
                                <td><span class="p-1 btn btn-warning" style="color:white;">{{ $data->status }}</span></td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('handler.pernikahan.show', $data->id) }}" class="btn btn-info">Detail</a>
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
    @elseif(Auth::user()->role->nama == "Admin Kartu Keluarga")
        <a href="{{ route('kkj.index') }}" class="btn btn-primary">Pergi ke halaman kkj</a> 
        <div class="card mt-3 p-3">
            <div class="card-title">
                <h2>Status Waiting</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="min-width: 200px">Nama Kepala Keluarga</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $i => $data)
                        <tr>
                            <td>{{ $i + $datas->FirstItem() }}</td>
                            <td>{{ $data->nama_kepala_keluarga }}</td>
                            <td>{{ $data->email }}</td>
                            <td><span class="p-1 btn btn-warning" style="color:white;">{{ $data->status }}</span></td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a href="{{ route('handler.kkj.show', $data->id) }}" class="btn btn-info">Detail</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>{{ $datas->links() }}</div>
        </div>
    @endif
</div>
@endsection