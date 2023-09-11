@extends('main')

@section('title')
Buat Data Pernikahan
@endsection

@section('content')
<form action="{{ route('pernikahan.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div  style="margin:1rem auto; width: 91%">
        @if (!isset($data))
        <div class="card" style="margin-bottom: 1rem">
            <div class="card-body">
                <div class="card-title mx-auto" style="width: fit-content"><p style="font-size: 20px; font-weight: 500;">Pernikahan</p></div>
                <div class="input-group" style="margin-bottom: 1rem;  margin-left: auto;margin-right: auto;">
                    <input type="text" placeholder="Kode Kartu Keluarga"class="form-control" name="search" id="search">
                    <select name="hubungan" id="hubungan" class="form-select">
                        <option value="anak">Anak</option>
                        <option value="keluarga">Keluarga</option>
                    </select>
                    <button class="btn btn-primary" type="button" onclick="Component.searchKkj({route: '{{ route('pernikahan.searchkkj') }}', token: '{{ csrf_token() }}'})">Search</button>
                </div>  
                <div class="form-group" hidden id="select-keluarga-anak" style="margin-top: 1rem">
                    <select name="id" class="form-select mx-auto" id="keluarga_anak_id" onchange="Component.getDataPengantin({route:'{{ route('pernikahan.getKandidat') }}',select:this, token:'{{ csrf_token() }}'})">
                        {{-- ajax --}}
                    </select>
                </div>
            </div>
        </div>
        @endif
        {{-- form --}}
        <div class="card" id="card_pria" style="margin-bottom: 1rem" hidden>
            <div class="card-body">
                {{-- data pria --}}
                <div id="pengantin_pria">
                    <p style="font-weight: 500; font-size: 20px">Pengantin Pria</p>
                    @if (isset($data))
                        <input type="hidden" value="{{ $data->pengantin_pria->id }}" name="pengantin_pria_id">
                    @endif
                    <div class="form-group">
                        <label for="nama_pria">Nama Pria</label>
                        <input type="text" name="nama_pria" id="nama_pria" value="{{ isset($data) ? $data->pengantin_pria->nama : '' }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Hari, Tanggal Baptis Selam</label>
                        <input type="datetime-local" class="form-control" name="waktu_baptis_pria" value="{{ isset($data) ? $data->pengantin_pria->waktu_baptis : '' }}" id="waktu_baptis_pria">
                    </div>
                    <div class="form-group">
                        <label for="gereja_pria">Baptis di Gereja</label>
                        <input type="text" class="form-control" name="gereja_pria" value="{{ isset($data) ? $data->pengantin_pria->gereja : '' }}" id="gereja_pria">
                    </div>
                    <div class="form-group">
                        <label for="no_kkj_pria">No. Kartu Keluarga Jemaat</label>
                        <input type="text" class="form-control" name="no_kkj_pria" value="{{ isset($data) ? $data->pengantin_pria->no_kkj : '' }}" id="no_kkj_pria">
                    </div>
                    <div class="form-group">
                        <label for="no_ktp_pria">No. KTP</label>
                        <input type="number" class="form-control" name="no_ktp_pria" value="{{ isset($data) ? $data->pengantin_pria->no_ktp : '' }}" id="no_ktp_pria">
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir_pria">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tmpt_lahir_pria" value="{{ isset($data) ? $data->pengantin_pria->tmpt_lahir : '' }}" id="tmpt_lahir_pria">
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir_pria">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir_pria" value="{{ isset($data) ? $data->pengantin_pria->tgl_lahir : '' }}" id="tgl_lahir_pria">
                    </div>
                    <div class="form-group">
                        <label for="status_pernikahan_pria">Status Pernikahan</label>
                        <select name="status_pernikahan_pria" id="status_pernikahan_pria" class="form-select">
                            <option value="" selected hidden>Pilih Status Pernikahan</option>
                            <option {{ isset($data) ? ($data->pengantin_pria->status_menikah == "Belum Pernah" ? 'selected' : '') : '' }} value="Belum Pernah">Belum Pernah</option>
                            <option {{ isset($data) ? ($data->pengantin_pria->status_menikah == "Sudah Pernah" ? 'selected' : '') : '' }} value="Sudah Pernah">Sudah Pernah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat_pria">Alamat Saat Ini</label>
                        <textarea class="form-control" name="alamat_pria" id="alamat_pria">{{ isset($data) ? $data->pengantin_pria->alamat : '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_pria">No Telepon untuk dihubungi</label>
                        <input type="number" class="form-control" value="{{ isset($data) ? $data->pengantin_pria->no_telp : '' }}" name="no_telp_pria" id="no_telp_pria">
                    </div>
                    <div class="form-group">
                        <label for="nama_ayah_pria">Nama Ayah</label>
                        <input type="text" class="form-control" name="nama_ayah_pria" value="{{ isset($data) ? $data->pengantin_pria->nama_ayah : '' }}" id="nama_ayah_pria">
                    </div>
                    <div class="form-group">
                        <label for="nama_ibu_pria">Nama Ibu</label>
                        <input type="text" class="form-control" name="nama_ibu_pria" value="{{ isset($data) ? $data->pengantin_pria->nama_ibu : '' }}" id="nama_ibu_pria">
                    </div>
                    <div class="form-group">
                        <label for="nama_ibu_pria">Nama Ibu</label>
                        <input type="text" class="form-control" name="nama_ibu_pria" value="{{ isset($data) ? $data->pengantin_pria->nama_ibu : '' }}" id="nama_ibu_pria">
                    </div>
                    <div class="form-group">
                        <label for="">Foto Pria</label>
                        <input type="file" {{ isset($data) ? '' : 'required' }} accept="image/*" class="form-control" name="foto_pria">
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="card_wanita" style="margin-bottom: 1rem" {{ isset($data) ? '' : 'hidden' }}>
            <div class="card-body">
                {{-- data pria --}}
                <div id="pengantin_wanita">
                    <p style="font-weight: 500; font-size: 20px">Pengantin Wanita</p>
                    @if (isset($data))
                        <input type="hidden" value="{{ $data->pengantin_wanita->id }}" name="pengantin_wanita_id">
                    @endif
                    <div class="form-group">
                        <label for="nama_wanita">Nama Wanita</label>
                        <input type="text" name="nama_wanita" value="{{ isset($data) ? $data->pengantin_wanita->nama : '' }}" id="nama_wanita" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Hari, Tanggal Baptis Selam</label>
                        <input type="datetime-local" class="form-control" value="{{ isset($data) ? $data->pengantin_wanita->waktu_baptis : '' }}" name="waktu_baptis_wanita" id="waktu_baptis_wanita">
                    </div>
                    <div class="form-group">
                        <label for="gereja_wanita">Baptis di Gereja</label>
                        <input type="text" class="form-control" name="gereja_wanita" value="{{ isset($data) ? $data->pengantin_wanita->gereja : '' }}" id="gereja_wanita">
                    </div>
                    <div class="form-group">
                        <label for="no_kkj_wanita">No. Kartu Keluarga Jemaat</label>
                        <input type="text" class="form-control" name="no_kkj_wanita" value="{{ isset($data) ? $data->pengantin_wanita->no_kkj : '' }}" id="no_kkj_wanita">
                    </div>
                    <div class="form-group">
                        <label for="no_ktp_wanita">No. KTP</label>
                        <input type="number" class="form-control" name="no_ktp_wanita" value="{{ isset($data) ? $data->pengantin_wanita->no_ktp : '' }}" id="no_ktp_wanita">
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir_wanita">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tmpt_lahir_wanita" value="{{ isset($data) ? $data->pengantin_wanita->tmpt_lahir : '' }}" id="tmpt_lahir_wanita">
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir_wanita">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir_wanita" value="{{ isset($data) ? $data->pengantin_wanita->tgl_lahir : '' }}" id="tgl_lahir_wanita">
                    </div>
                    <div class="form-group">
                        <label for="status_pernikahan_wanita">Status Pernikahan</label>
                        <select name="status_pernikahan_wanita" id="status_pernikahan_wanita" class="form-select">
                            <option value="" selected hidden>Pilih Status Pernikahan</option>
                            <option {{ isset($data) ? ($data->pengantin_wanita->status_menikah == "Belum Pernah" ?'selected' : '') : '' }} value="Belum Pernah">Belum Pernah</option>
                            <option {{ isset($data) ? ($data->pengantin_wanita->status_menikah == "Sudah Pernah" ?'selected' : '') : '' }}  value="Sudah Pernah">Sudah Pernah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat_wanita">Alamat Saat Ini</label>
                        <textarea class="form-control" name="alamat_wanita" id="alamat_wanita">{{ isset($data) ? $data->pengantin_wanita->alamat : '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_wanita">No Telepon untuk di hubungi</label>
                        <input class="form-control" name="no_telp_wanita" value="{{ isset($data) ? $data->pengantin_wanita->no_telp : '' }}" id="no_telp_wanita">
                    </div>
                    <div class="form-group">
                        <label for="nama_ayah_wanita">Nama Ayah</label>
                        <input class="form-control" name="nama_ayah_wanita" value="{{ isset($data) ? $data->pengantin_wanita->nama_ayah : '' }}" id="nama_ayah_wanita">
                    </div>
                    <div class="form-group">
                        <label for="nama_ibu_wanita">Nama Ibu</label>
                        <input class="form-control" name="nama_ibu_wanita" value="{{ isset($data) ? $data->pengantin_wanita->nama_ibu : '' }}" id="nama_ibu_wanita">
                    </div>
                    <div class="form-group">
                        <label for="">Foto Wanita</label>
                        <input type="file" {{ isset($data) ? '' : 'required' }} accept="image/*" class="form-control" name="foto_wanita">
                    </div>
                </div>
            </div>
        </div>
        {{-- other --}}
        <div class="card" style="margin-bottom: 1rem">
            <small style="font-weight: 500"></small>
            <div class="card-body">
                <p style="font-size: 20px; font-weight: 500">Data Lainnya</p>
                <div class="form-group">
                    <label for="email">Email untuk di hubungi</label>
                    <input type="email" class="form-control" name="email" value="{{ isset($data) ? $data->email : '' }}">
                </div>
                <div class="form-group">
                    <label for="">Pemberkatan Hari, Tanggal, Jam</label>
                    <input type="datetime-local" class="form-control" value="{{ isset($data) ? $data->waktu_pernikahan : '' }}" name="waktu_pernikahan">
                </div>
                <div class="form-group">
                    <label for="">Tempat Pernikahan</label>
                    <textarea name="tmpt_pernikahan" id="tmpt_pernikahan" class="form-control">{{ isset($data) ? $data->tmpt_pernikahan : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="">Alamat Setelah Menikah</label>
                    <textarea name="alamat_setelah_menikah" id="alamat_setelah_menikah" class="form-control">{{ isset($data) ? $data->alamat_setelah_menikah : '' }}</textarea>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between">
                    <a href="{{ route('pernikahan.index') }}" class="btn btn-danger" style="margin-top: 1rem">Kembali</a>
                    <button class="btn btn-primary" style="margin-top: 1rem">{{ isset($data) ? 'Ubah Data' : 'Buat Baru' }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection