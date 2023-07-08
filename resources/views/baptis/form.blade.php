@extends('main')

@section('title')
    Baptis
@endsection

@section('content')
<div class="card" style="margin:1rem auto; width: 91%">
    <form action="{{ isset($data) ? route('baptis.update', $data->id) : route('baptis.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="card-body">
            {{-- data kandidat --}}
            <div id="data_kandidat">
                {{-- ajax --}}
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <div class="row">
                        <div class="col">
                            <input type="text" disabled value="{{ isset($data) ? ($data->kkj_anak ? $data->kkj_anak->nama : $data->kkj_keluarga->nama) : '' }}" name="nama" class="form-control">
                        </div>
                        <div class="col-5">
                            <input type="text" disabled value="{{ isset($data) ? ($data->kkj_anak ? ($data->kkj_anak->jk == 'L' ? 'Laki-Laki':'Perempuan' ) : ($data->kkj_keluarga->jk == 'L' ? 'Laki-Laki':'Perempuan' )) : '' }}" name="jk" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" disabled>{{ isset($data) ? ($data->kkj_anak ? $data->kkj_anak->kkj->alamat : $data->kkj_keluarga->kkj->alamat ) : ''}}</textarea>
                </div>
                <div class="form-group">
                    <label for="tmpt_lahir">Tempat & Tanggal Lahir</label>
                    <input type="text" class="form-control" disabled value="{{ isset($data) ? ($data->kkj_anak ? $data->kkj_anak->tmpt_lahir .', '. Carbon\Carbon::parse($data->kkj_anak->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y') : $data->kkj_keluarga->tmpt_lahir .', '. Carbon\Carbon::parse($data->kkj_keluarga->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y') ) : '' }}">
                </div>
                <div class="form-group">
                    <label for="">Nama Ayah</label>
                    <input type="text" disabled class="form-control" value="{{ isset($data) ? ($data->kkj_anak ? $data->kkj_anak->kkj_kepala_keluarga->nama : $data->kkj_keluarga->kkj_kepala_keluarga->nama ) :'' }}">
                </div>
                <div class="form-group">
                    <label for="">Nama Ibu</label>
                    <input type="text" disabled class="form-control" value="{{ isset($data) ? ($data->kkj_anak ? $data->kkj_anak->kkj_pasangan->nama : $data->kkj_keluarga->kkj_pasangan->nama ) :'' }}">
                </div>
            </div>
            {{-- /data kandidat --}}
            <div class="form-group">
                <label for="waktu">Tanggal Baptis</label>
                <input type="datetime-local" class="form-control" value="{{ isset($data) ? $data->waktu : '' }}" name="waktu" id="waktu" required>
            </div>
            <div class="form-group">
                <label for="pendeta">Pendeta</label>
                <input type="text" class="form-control" id="pendeta" value="{{ isset($data) ? $data->pendeta : '' }}" name="pendeta" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" {{ isset($data) ? '' : 'required' }}>
            </div>
            <button class="btn btn-primary" style="margin-top: 1rem">Submit</button>
        </div>
    </form>
</div>
@endsection