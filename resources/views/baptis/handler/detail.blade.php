@extends('main')

@section('content')
<div class="p-3">
    <h2>Data Baptis GBI (Gereja Bethel Indonesia)</h2>

    <form action="{{ route('handler.baptis.update', $data->id) }}" method="post">
        @csrf
        @method("patch")
        <div class="card">
            <div class="card-body">
                {{-- data kandidat --}}
                <div>
                    <div class="form-group">
                        <label for="nama">Nama : {{ $data->anggota_keluarga->nama }}</label>
                    </div>
                    <div>
                        <label for="nama">Jenis Kelamin : {{ $data->anggota_keluarga->jk == "L"? "Laki Laki":"Perempuan" }}</label>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat : {{  $data->kkj->alamat }}</label>
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir">Tempat & Tanggal Lahir : {{  $data->anggota_keluarga->tmpt_lahir .', '. Carbon\Carbon::parse($data->anggota_keluarga->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y') }}</label>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Ayah : {{  $data->kepala_keluarga->nama }}</label>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Ibu : {{  $data->pasangan ? $data->pasangan->nama : 'Tidak Ada' }}</label>
                    </div>
                </div>
                {{-- /data kandidat --}}
                <div class="form-group">
                    <label for="waktu">Tanggal Baptis : {{ Carbon\Carbon::parse($data->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</label>
                </div>
                <div class="form-group">
                    <label for="pendeta">Pendeta : {{ $data->pendeta ? $data->pendeta->nama : ""}}</label>
                </div>
                <div>
                    <label for="">Foto</label>
                    <div>
                        <img src="{{ asset('storage/'.$data->foto) }}" alt="" style="object-fit: contain; width: 300px; height: 200px;">
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3 p-3">
            <div class="card-body" style="display: flex; justify-content: space-between; align-items: center">
                <button class="btn btn-danger" name="response" value="false">Tolak</button>
                <button class="btn btn-primary" name="response" value="true">Terima</button>
            </div>
        </div>
    </form>
</div>
@endsection