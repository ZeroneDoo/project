@extends('main')

@section('title')
    {{ isset($data) ? 'Ubah Kartu Keluarga Jemaat' : 'Buat Kartu Keluarga Jemaat' }}
@endsection

@push('css')
    <style>
        .card-anak {
            display: grid;
            columns: 2;
        }
    </style>
@endpush

@section('content')
<form action="{{ isset($data) ? route('kkj.update', $data->id) : route('kkj.store') }}" method="POST">
@csrf
@if (isset($data))
    @method("patch")
@endif
<div style="margin: 3rem auto; width: 91%">
        {{-- data umum --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="margin-bottom: 1.5rem">{{ isset($data) ? 'Ubah Kartu Keluarga Jemaat' : 'Buat Kartu Keluarga Jemaat' }}</h5>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" name="email" value="{{ isset($data) ? $data->email : old('email') }}"
                        style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="email">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat *</label>
                    <textarea name="alamat" class="form-control" style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="alamat">{{ isset($data) ? $data->alamat : old('alamat') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="rt_rw">RT/RW *</label>
                    <input type="text" class="form-control" value="{{ isset($data) ? $data->rt_rw : old('rt_rw') }}" style="margin-top: 0.75rem; margin-bottom: 0.75rem"
                        name="rt_rw" id="rt_rw">
                </div>
                <div class="form-group">
                    <label for="telp">No Telepon *</label>
                    <input type="number" class="form-control" value="{{ isset($data) ? $data->telp : old('telp') }}" style="margin-top: 0.75rem; margin-bottom: 0.75rem"
                        name="telp" id="telp">
                </div>
                <div class="form-group">
                    <label for="provinsi">Provinsi *</label>
                    <div style="margin-top: 0.75rem; margin-bottom: 0.75rem">
                        <select name="provinsi" onchange="Component.getKota(this)" class="form-select" id="provinsi">
                            <option></option>
                            {{-- ajax --}}
                        </select>
                        @if (isset($data))
                        <small style="font-weight: 500">Sebelumnya : {{ $data->provinsi }}</small>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="kabupaten">Kabupaten/Kota *</label>
                    <div style="margin-top: 0.75rem; margin-bottom: 0.75rem">
                        <select name="kabupaten" onchange="Component.getKecamatan(this)" class="form-select" id="kabupaten">
                            <option></option>
                            {{-- ajax --}}
                        </select>
                        @if (isset($data))
                        <small style="font-weight: 500">Sebelumnya : {{ $data->kabupaten }}</small>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan *</label>
                    <div style="margin-top: 0.75rem; margin-bottom: 0.75rem">
                        <select name="kecamatan" class="form-select" id="kecamatan">
                            <option></option>
                            {{-- ajax --}}
                        </select>
                        @if (isset($data))
                        <small style="font-weight: 500">Sebelumnya : {{ $data->kecamatan }}</small>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="status_menikah">Status Menikah *</label>
                    <select name="status_menikah" style="margin-top: 0.75rem; margin-bottom: 0.75rem"
                        class="form-select" id="status_menikah" onchange="Component.statusMenikah(this)">
                        <option value="" hidden selected>Status Menikah</option>
                        @foreach ($status_menikah as $status)
                            <option {{ isset($data) ? ($status == $data->status_menikah ? 'selected' : '') : '' }} value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- data anggota --}}
        <div class="row" style="margin-top: 1.5rem">
            {{-- kepala keluarga --}}
            <div class="col-sm mb-3" id="card_kepala_keluarga" hidden>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="margin-bottom: 1.5rem">Kepala Keluarga</h5>
                        <div class="form-group">
                            <label for="nama_kepala_keluarga">Nama Lengkap *</label>
                            <div class="row" style="margin-top: 0.75rem; margin-bottom: 0.75rem">
                                <div class="col">
                                    <input type="text" value="{{ isset($data) ? $data->kkj_kepala_keluarga->nama : old("nama_kepala_keluarga")}}" class="form-control" name="nama_kepala_keluarga"
                                        id="nama_kepala_keluarga">
                                </div>
                                <div class="col-5">
                                    <select name="jk" class="form-select" id="jk">
                                        <option value="" hidden selected>Jenis Kelamin</option>
                                        <option {{ isset($data) ? ($data->kkj_kepala_keluarga->jk == "L" ? 'selected' : '') : '' }} value="L">Laki-Laki</option>
                                        <option {{ isset($data) ? ($data->kkj_kepala_keluarga->jk == "P" ? 'selected' : '') : '' }} value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tmpt_lahir">Tempat Lahir *</label>
                            <input type="text" value="{{ isset($data) ? $data->kkj_kepala_keluarga->tmpt_lahir : old('tmpt_lahir') }}" class="form-control" name="tmpt_lahir"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tmpt_lahir">
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir *</label>
                            <input type="date" value="{{ isset($data) ? $data->kkj_kepala_keluarga->tgl_lahir : old('tgl_lahir') }}" class="form-control" name="tgl_lahir"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tgl_lahir">
                        </div>
                        <div class="form-group">
                            <label for="pendidikan_terakhir">Pendidikan Terakhir  *</label>
                            <input type="text" value="{{ isset($data) ? $data->kkj_kepala_keluarga->pendidikan_terakhir : old('pendidikan_terakhir') }}" class="form-control" name="pendidikan_terakhir"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pendidikan_terakhir">
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan  *</label>
                            <input type="text" value="{{ isset($data) ? $data->kkj_kepala_keluarga->pekerjaan : old('pekerjaan') }}" class="form-control" name="pekerjaan"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="baptis_date">Baptis Selam *</label>
                            <input type="date" value="{{ isset($data) ? $data->kkj_kepala_keluarga->baptis : old('baptis') }}" class="form-control" name="baptis_date"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="baptis_date">
                        </div>
                    </div>
                </div>
            </div>
            {{-- pasangan --}}
            @if (isset($data->kkj_pasangan))
            <div class="col" id="card_pasangan" aria-disabled="true" hidden>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="margin-bottom: 1.5rem">Pasangan</h5>
                        <div class="form-group">
                            <label for="nama_pasangan">Nama Lengkap *</label>
                            <div class="row" style="margin-top: 0.75rem; margin-bottom: 0.75rem">
                                <div class="col">
                                    <input type="text" value="{{ isset($data) ? $data->kkj_pasangan->nama : old('nama') }}" class="form-control" name="nama_pasangan"
                                        id="nama_pasangan">
                                </div>
                                <div class="col-5">
                                    <select name="jk_pasangan" class="form-select" id="jk_pasangan">
                                        <option value="" hidden selected>Jenis Kelamin</option>
                                        <option {{ isset($data) ? ($data->kkj_pasangan->jk == "L" ? 'selected' : '' ) : '' }} value="L">Laki-Laki</option>
                                        <option {{ isset($data) ? ($data->kkj_pasangan->jk == "P" ? 'selected' : '') : '' }} value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tmpt_lahir_pasangan">Tempat Lahir *</label>
                            <input type="text" class="form-control" value="{{ isset($data) ? $data->kkj_pasangan->tmpt_lahir : old('tmpt_lahir') }}" name="tmpt_lahir_pasangan"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tmpt_lahir_pasangan">
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir_pasangan">Tanggal Lahir *</label>
                            <input type="date" class="form-control" value="{{ isset($data) ? $data->kkj_pasangan->tgl_lahir : old('tgl_lahir') }}" name="tgl_lahir_pasangan"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tgl_lahir_pasangan">
                        </div>
                        <div class="form-group">
                            <label for="pendidikan_terakhir_pasangan">Pendidikan Terakhir  *</label>
                            <input type="text" class="form-control" value="{{ isset($data) ? $data->kkj_pasangan->pendidikan_terakhir : old('pendidikan_terakhir') }}" name="pendidikan_terakhir_pasangan"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pendidikan_terakhir_pasangan">
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan_pasangan">Pekerjaan  *</label>
                            <input type="text" class="form-control" value="{{ isset($data) ? $data->kkj_pasangan->pekerjaan : old('pekerjaan') }}" name="pekerjaan_pasangan"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pekerjaan_pasangan">
                        </div>
                        <div class="form-group">
                            <label for="baptis_date_pasangan">Baptis Selam *</label>
                            <input type="date" class="form-control" value="{{ isset($data) ? $data->kkj_pasangan->baptis : old('baptis') }}" name="baptis_date_pasangan"
                                style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="baptis_date_pasangan">
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        {{-- anak --}}
        <div style="margin-bottom: 1.25rem" id="anak">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-center justify-content-between">
                        <div class="flex-item">
                            <p style="font-size: 20px; font-weight: 600;">Data Anak</p>
                        </div>
                        <div class="flex-item">
                            <button type="button" class="btn btn-primary" onclick="Component.tambahAnak()">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4" style="margin-bottom: 0.75rem;" id="card_anak">
            {{-- list --}}
            {{-- ajax --}}
            @if (isset($data))
                @foreach ($data->kkj_anak as $anak)
                <div class="col-sm-6">
                    <input type="hidden" name="id_anak[]" value="{{ $anak->id }}" id="id_anak">
                        <div class="card">
                            <div style="display: flex; justify-content: space-between; padding: 0.75rem">
                                <p style="font-size: 20px; font-weight: 500">{{ $anak->nama }}</p>
                                {{-- <button type="button" onclick="Component.destroyAnak({ url: '{{ route('kkj.destroy.anak', $anak->id) }}', token: '{{ csrf_token() }}'})" class="btn btn-danger">Hapus Anak</button> --}}
                                <a href="{{ route('kkj.destroy.anak', $anak->id) }}" class="btn btn-danger">Hapus Anak</a>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_anak_edit">Nama Lengkap *</label>
                                    <div class="row" style="margin-top: 0.75rem; margin-bottom: 0.75rem">
                                        <div class="col">
                                            <input type="text" value="{{ isset($data) ? $anak->nama : old("nama_anak_edit") }}" class="form-control" name="nama_anak_edit[]"
                                                id="nama_anak_edit">
                                        </div>
                                        <div class="col-5">
                                            <select name="jk_anak_edit[]" class="form-select" id="jk_anak_edit">
                                                <option value="" hidden selected>Jenis Kelamin</option>
                                                <option {{ isset($data) ? ($anak->jk == "L" ? 'selected' : '') : '' }} value="L">Laki-Laki</option>
                                                <option {{ isset($data) ? ($anak->jk == "P" ? 'selected' : '') : '' }} value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tmpt_lahir_anak_edit">Tempat Lahir *</label>
                                    <input type="text" value="{{ isset($data) ? $anak->tmpt_lahir : old("tmpt_lahir_anak_edit") }}" class="form-control" name="tmpt_lahir_anak_edit[]"
                                        style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tmpt_lahir_anak_edit">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_lahir_anak_edit">Tanggal Lahir *</label>
                                    <input type="date" value="{{ isset($data) ? $anak->tgl_lahir : old("tgl_lahir_anak_edit") }}" class="form-control" name="tgl_lahir_anak_edit[]"
                                        style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tgl_lahir_anak_edit">
                                </div>
                                <div class="form-group">
                                    <label for="pendidikan_anak_edit">Pendidikan *</label>
                                    <input type="text" value="{{ isset($data) ? $anak->pendidikan : old("pendidikan_anak_edit") }}" class="form-control" name="pendidikan_anak_edit[]"
                                        style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pendidikan_anak_edit">
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan_anak_edit">Pekerjaan (optional)</label>
                                    <input type="text" value="{{ isset($data) ? $anak->pekerjaan : old("pekerjaan_anak_edit") }}" class="form-control" name="pekerjaan_anak_edit[]"
                                        style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pekerjaan_anak_edit">
                                </div>
                                <div class="form-group">
                                    <label for="diserahkan_anak_edit">Diserahkan *</label>
                                    <select name="diserahkan_anak_edit[]" style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="diserahkan_anak_edit">
                                        <option value="" hidden selected>Diserahkan</option>
                                        <option {{ isset($data) ? ($anak->diserahkan == "Y" ? 'selected' : '') : '' }} value="Y">Iya</option>
                                        <option {{ isset($data) ? ($anak->diserahkan == "T" ? 'selected' : '') : '' }} value="T">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="baptis_anak_edit">Baptis Selam *</label>
                                    <select name="baptis_anak_edit[]" style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="baptis_anak_edit">
                                        <option value="" hidden selected>Baptis Selam</option>
                                        <option {{ isset($data) ? ($anak->baptis == "Y" ? 'selected' : '') : '' }} value="Y">Iya</option>
                                        <option {{ isset($data) ? ($anak->baptis == "T" ? 'selected' : '') : '' }} value="T">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nikah_anak_edit">Nikah *</label>
                                    <select name="nikah_anak_edit[]" style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="nikah_anak_edit">
                                        <option value="" hidden selected>Nikah</option>
                                        <option {{ isset($data) ? ($anak->nikah == "Y" ? 'selected' : '') : '' }} value="Y">Iya</option>
                                        <option {{ isset($data) ? ($anak->nikah == "T" ? 'selected' : '') : '' }} value="T">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{-- keluarga --}}
        <div style="margin-bottom: 2rem;">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-center justify-content-between">
                        <div class="flex-item">
                            <p style="font-size: 20px; font-weight: 600;">Data Keluarga</p>
                        </div>
                        <div class="flex-item">
                            <button type="button" class="btn btn-primary" onclick="Component.tambahKeluarga()">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4" id="card_keluarga">
            {{-- list --}}
            {{-- ajax --}}
            @if (isset($data))
                @foreach ($data->kkj_keluarga as $keluarga)
                <div class="col-sm-6">
                    <input type="hidden" name="id_keluarga[]" value="{{ $keluarga->id }}" id="id_keluarga">
                        <div class="card">
                            <div style="display: flex; justify-content: space-between; padding: 0.75rem">
                                <p style="font-size: 20px; font-weight: 500">{{ $keluarga->nama }}</p>
                                {{-- <button onclick="Component.destroyKeluarga({ url: '{{ route('kkj.destroy.keluarga', $keluarga->id) }}', token: '{{ csrf_token() }}'})" type="button" class="btn btn-danger">Hapus Keluarga</button> --}}
                                <a href="{{ route('kkj.destroy.keluarga', $keluarga->id) }}" class="btn btn-danger">Hapus Keluarga</a>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_keluarga_edit">Nama Lengkap *</label>
                                    <div class="row" style="margin-top: 0.75rem; margin-bottom: 0.75rem">
                                        <div class="col">
                                            <input type="text" value="{{ $keluarga->nama }}" class="form-control" name="nama_keluarga_edit[]"
                                                id="nama_keluarga_edit">
                                        </div>
                                        <div class="col-5">
                                            <select name="jk_keluarga_edit[]" class="form-select" id="jk_keluarga_edit">
                                                <option value="" hidden selected>Jenis Kelamin</option>
                                                <option {{ $keluarga->jk == "L" ? 'selected' : '' }} value="L">Laki-Laki</option>
                                                <option {{ $keluarga->jk == "P" ? 'selected' : '' }} value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tmpt_lahir_keluarga_edit">Tempat Lahir *</label>
                                    <input type="text" class="form-control" value="{{ $keluarga->tmpt_lahir }}" name="tmpt_lahir_keluarga_edit[]"
                                        style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tmpt_lahir_keluarga_edit">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_lahir_keluarga_edit">Tanggal Lahir *</label>
                                    <input type="date" class="form-control" value="{{ $keluarga->tgl_lahir }}" name="tgl_lahir_keluarga_edit[]"
                                        style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="tgl_lahir_keluarga_edit">
                                </div>
                                <div class="form-group">
                                    <label for="pendidikan_keluarga_edit">Pendidikan *</label>
                                    <input type="text" class="form-control" value="{{ $keluarga->pendidikan }}" name="pendidikan_keluarga_edit[]"
                                        style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pendidikan_keluarga_edit">
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan_keluarga_edit">Pekerjaan (optional)</label>
                                    <input type="text" class="form-control" value="{{ $keluarga->pekerjaan }}" name="pekerjaan_keluarga_edit[]"
                                        style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="pekerjaan_keluarga_edit">
                                </div>
                                <div class="form-group">
                                    <label for="diserahkan_keluarga_edit">Diserahkan *</label>
                                    <select name="diserahkan_keluarga_edit[]" style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="diserahkan_keluarga_edit">
                                        <option value="" hidden selected>Diserahkan</option>
                                        <option {{ $keluarga->diserahkan == "Y" ? 'selected' : "" }} value="Y">Iya</option>
                                        <option {{ $keluarga->diserahkan == "T" ? 'selected' : "" }} value="T">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="baptis_keluarga_edit">Baptis Selam *</label>
                                    <select name="baptis_keluarga_edit[]" style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="baptis_keluarga_edit">
                                        <option value="" hidden selected>Baptis Selam</option>
                                        <option {{ $keluarga->baptis == "Y" ? 'selected' : "" }} value="Y">Iya</option>
                                        <option {{ $keluarga->baptis == "T" ? 'selected' : "" }} value="T">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nikah_keluarga_edit">Nikah *</label>
                                    <select name="nikah_keluarga_edit[]" style="margin-top: 0.75rem; margin-bottom: 0.75rem" class="form-select" id="nikah_keluarga_edit">
                                        <option value="" hidden selected>Nikah</option>
                                        <option {{ $keluarga->nikah == "Y" ? 'selected' : "" }} value="Y">Iya</option>
                                        <option {{ $keluarga->nikah == "T" ? 'selected' : "" }} value="T">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="card" style="margin-top: 1.5rem">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between">
                    <a href="{{ route('kkj.index') }}" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Ubah' : 'Buat Baru' }}</button>
                </div>
            </div>
        </div>
    </div>
</form> 
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#provinsi').select2({
                placeholder: "Pilih Provinsi",
            });
            $('#kabupaten').select2({
                placeholder: "Pilih Kabupaten/Kota",
            });
            $('#kecamatan').select2({
                placeholder: "Pilih Kecamatan",
            });

            if('{{ isset($data) }}' == 1) {
                getDaerah()
                Component.statusMenikah("#status_menikah")
            }
            
            if("{{ isset($data) }}" == 0) {
                $("#provinsi").val() ? $("#kabupaten").prop("disabled", false) : $("#kabupaten").prop("disabled", true) 
                $("#provinsi").val() && $("#kabupaten").val() ? $("#kecamatan").prop("disabled", false) : $("#kecamatan").prop("disabled", true)
            } 

            
            Component.getProvinsi()
        });
    </script>

    @if (isset($data))
        <script>
            async function getDaerah () { 
                await Component.getProvinsi("{{ $data->provinsi }}")
                await Component.getKota("#provinsi", "{{ $data->kabupaten }}")
                await Component.getKecamatan("#kabupaten", "{{ $data->kecamatan }}")
            }
        </script>
    @endif
@endpush