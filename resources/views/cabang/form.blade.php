@extends('main')

@section('title')
    {{ isset($data) ? 'Edit Pendeta' : 'Tambah Pendeta' }}
@endsection

@section('content')
<div style="margin: 3rem auto; width: 91%">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4 card-title">{{ isset($data) ? 'Edit Cabang' : 'Tambah Cabang' }}</h5>
            <form method="POST" action="{{ isset($data) ? route('cabang.update', $data->id) :  route('cabang.store') }}" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                    @method("patch")
                @endif
                <div class="form-group">
                    <label for="nama">Nama Cabang</label>
                    <input type="text" required autocomplete="off" value="{{ isset($data) ? $data->nama : old('nama') }}" name="nama" class="mb-4 form-control" id="nama">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea required  name="deskripsi" class="mb-4 form-control" id="deskripsi">{{ isset($data) ? $data->deskripsi : old('deskripsi') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea required  name="alamat" class="mb-4 form-control" id="alamat">{{ isset($data) ? $data->alamat : old('alamat') }}</textarea>
                </div>
                {{-- pendeta --}}
                <div style="margin-bottom: 2rem;">
                    <div class="d-flex align-center justify-content-between">
                        <div class="flex-item">
                            <p style="font-size: 18px; font-weight: 600;">List Pendeta</p>
                        </div>
                        <div class="flex-item">
                            <button type="button" class="btn btn-primary" onclick="Component.addListPendeta()">+</button>
                        </div>
                    </div>
                </div>
                <div id="list_pendeta">
                    @isset($data)
                        @foreach ($data->pendeta_cabang as $pendeta)
                            <div class="mb-4" style="display: flex; gap: 10px;">
                                <input type="hidden" class="form-control" value="{{ $pendeta->id }}" name="pendeta_edit_id[]">
                                <input type="text" class="form-control" value="{{ $pendeta->pendeta }}" name="pendeta_edit[]">
                                <a href="{{ route('cabang.destroy.pendeta',$pendeta->id) }}" class="btn btn-danger">Hapus</a>
                            </div>
                        @endforeach
                    @endisset
                </div>
                {{-- jadwal ibadah --}}
                <div style="margin-bottom: 2rem;">
                    <div class="d-flex align-center justify-content-between">
                        <div class="flex-item">
                            <p style="font-size: 18px; font-weight: 600;">Jadwal Ibadah</p>
                        </div>
                        <div class="flex-item">
                            <button type="button" class="btn btn-primary" onclick="Component.addJadwalIbadah()">+</button>
                        </div>
                    </div>
                </div>
                <div id="jadwal_ibadah">
                    @isset($data)
                        @foreach ($data->cabang_ibadah as $ibadah)
                            <div class="mb-4 card">
                                <div style="margin:0.75rem;display: flex; justify-content: space-between;">
                                    <input type="hidden" value="{{ $ibadah->id }}" name="ibadah_edit_id[]">
                                    <div></div>
                                    <a href="{{ route('cabang.destroy.ibadah',$ibadah->id) }}" class="btn btn-danger">Hapus</a>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label> Hari Ibadah </label>
                                        <input type="text" value="{{ $ibadah->hari }}" class="form-control" name="hari_ibadah_edit[]">
                                    </div>
                                    <div class="form-group">
                                        <label> Waktu Ibadah </label>
                                        <input type="time" value="{{ $ibadah->waktu }}" class="form-control" name="waktu_ibadah_edit[]">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
                {{-- kegiatan --}}
                <div style="margin-bottom: 2rem;">
                    <div class="d-flex align-center justify-content-between">
                        <div class="flex-item">
                            <p style="font-size: 18px; font-weight: 600;">List Kegiatan</p>
                        </div>
                        <div class="flex-item">
                            <button type="button" class="btn btn-primary" onclick="Component.addListKegiatan()">+</button>
                        </div>
                    </div>
                </div>
                <div id="list_kegiatan">
                    @isset($data)
                        @foreach ($data->kegiatan as $kegiatan)
                            <div class="mb-4 card">
                                <div style="margin:0.75rem;display: flex; justify-content: space-between;">
                                    <input type="hidden" name="kegiatan_edit_id[]" value="{{ $kegiatan->id }}">
                                    <div></div>
                                    <a href="{{ route('cabang.destroy.kegiatan',$kegiatan->id) }}" class="btn btn-danger">Hapus</a>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label> Nama Kegiatan </label>
                                        <input type="text" class="mb-4 form-control" value="{{ $kegiatan->nama }}" name="nama_kegiatan_edit[]">
                                    </div>
                                    <div class="form-group">
                                        <label> Pendeta </label>
                                        <input type="text" class="mb-4 form-control" value="{{ $kegiatan->pendeta }}" name="pendeta_kegiatan_edit[]">
                                    </div>
                                    <div class="form-group">
                                        <label> Area </label>
                                        <textarea class="mb-4 form-control" name="area_kegiatan_edit[]">{{ $kegiatan->area }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label> Waktu Kegiatan</label>
                                        <input type="datetime-local" class="form-control" value="{{ $kegiatan->waktu }}" name="waktu_kegiatan_edit[]">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
                <div class="form-group">
                    <label for="nama">Foto Cabang</label>
                    <input type="file" accept="image/*" name="foto" class="mb-4 form-control" id="foto">
                    @isset($data)
                        @if($data->foto)
                            <img src="{{ asset('storage/'.$data->foto) }}" alt="" style="width: 300px; height: 200px; object-fit: cover">
                        @endif
                    @endisset
                </div>
                <div style="margin-top: 0.75rem; display: flex; gap: 5px">
                    <a href="{{ route('cabang.index') }}" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Ubah' : 'Buat Baru' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
