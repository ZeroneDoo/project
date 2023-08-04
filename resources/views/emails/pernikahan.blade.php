<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pernikahan GBI (Gereja Bethel Indonesia)</title>
</head>
<body>
    <h2>Data Pernikahan GBI (Gereja Bethel Indonesia)</h2>

    <div>
        {{-- form --}}
        <div class="card" id="card_pria" style="margin-bottom: 1rem">
            <div class="card-body">
                {{-- data pria --}}
                <div id="pengantin_pria">
                    <p style="font-size: 14px;font-weight: 600">Pengantin Pria</p>
                    <div class="form-group">
                        <label for="nama_pria">Nama Pria : {{ $data->pengantin_pria->anggota_keluarga ? $data->pengantin_pria->anggota_keluarga->nama : $data->pengantin_pria->nama }}</label>
                    </div>
                    <div class="form-group">
                        <label for="">Hari, Tanggal Baptis Selam : {{ Carbon\Carbon::parse($data->pengantin_pria->anggota_keluarga ?$data->baptiss->waktu : $data->pengantin_pria->waktu_baptis, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</label>
                    </div>
                    <div class="form-group">
                        <label for="gereja_pria">Baptis di Gereja : {{ $data->pengantin_pria->gereja }}</label>
                    </div>
                    <div class="form-group">
                        <label for="no_kkj_pria">No. Kartu Keluarga Jemaat : {{ $data->pengantin_pria->no_kkj }}</label>
                    </div>
                    <div class="form-group">
                        <label for="no_ktp_pria">No. KTP : {{ $data->pengantin_pria->no_ktp }}</label>
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir_pria">Tempat Lahir : {{ $data->pengantin_pria->anggota_keluarga ? $data->pengantin_pria->anggota_keluarga->tmpt_lahir : $data->pengantin_pria->tmpt_lahir}}</label>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir_pria">Tanggal Lahir : {{ Carbon\Carbon::parse($data->pengantin_pria->anggota_keluarga ? $data->pengantin_pria->anggota_keluarga->tgl_lahir : $data->pengantin_pria->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y') }}</label>
                    </div>
                    <div class="form-group">
                        <label for="status_perniakahan_pria">Status Pernikahan : {{ $data->pengantin_pria->status_menikah }}</label>
                    </div>
                    <div class="form-group">
                        <label for="alamat_pria">Alamat Saat Ini : {{ $data->pengantin_pria->alamat }}</label>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_pria">No Telepon untuk dihubungi : {{ $data->pengantin_pria->no_telp }}</label>
                    </div>
                    <div class="form-group">
                        <label for="nama_ayah_pria">Nama Ayah : {{ $data->pengantin_pria->anggota_keluarga ? $data->kepala_keluarga->nama : $data->pengantin_pria->nama_ayah }}</label>
                    </div>
                    <div class="form-group">
                        <label for="nama_ibu_pria">Nama Ibu : {{ $data->pengantin_pria->anggota_keluarga ? $data->pasangan->nama : $data->pengantin_pria->nama_ibu }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="card_wanita" style="margin-bottom: 1rem">
            <div class="card-body">
                {{-- data wanita --}}
                <div id="pengantin_pria">
                    <p style="font-weight: 600; font-size: 14px">Pengantin Wanita</p>
                    <div class="form-group">
                        <label for="nama_pria">Nama Wanita : {{ $data->pengantin_wanita->anggota_keluarga ? $data->pengantin_wanita->anggota_keluarga->nama : $data->pengantin_wanita->nama }}</label>
                    </div>
                    <div class="form-group">
                        <label for="">Hari, Tanggal Baptis Selam : {{ Carbon\Carbon::parse($data->pengantin_wanita->anggota_keluarga ?$data->baptiss->waktu : $data->pengantin_wanita->waktu_baptis, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</label>
                    </div>
                    <div class="form-group">
                        <label for="gereja_pria">Baptis di Gereja : {{ $data->pengantin_wanita->gereja }}</label>
                    </div>
                    <div class="form-group">
                        <label for="no_kkj_pria">No. Kartu Keluarga Jemaat : {{ $data->pengantin_wanita->no_kkj }}</label>
                    </div>
                    <div class="form-group">
                        <label for="no_ktp_pria">No. KTP : {{ $data->pengantin_wanita->no_ktp }}</label>
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir_pria">Tempat Lahir : {{ $data->pengantin_wanita->anggota_keluarga ? $data->pengantin_wanita->anggota_keluarga->tmpt_lahir : $data->pengantin_wanita->tmpt_lahir }}</label>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir_pria">Tanggal Lahir : {{ Carbon\Carbon::parse($data->pengantin_wanita->anggota_keluarga ? $data->pengantin_wanita->anggota_keluarga->tgl_lahir : $data->pengantin_wanita->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y') }}</label>
                    </div>
                    <div class="form-group">
                        <label for="status_perniakahan_pria">Status Pernikahan : {{ $data->pengantin_wanita->status_menikah }}</label>
                    </div>
                    <div class="form-group">
                        <label for="alamat_pria">Alamat Saat Ini : {{ $data->pengantin_wanita->alamat }}</label>
                    </div>
                    <div class="form-group">
                        <label for="no_telp_pria">No Telepon untuk dihubungi : {{ $data->pengantin_wanita->no_telp }}</label>
                    </div>
                    <div class="form-group">
                        <label for="nama_ayah_pria">Nama Ayah : {{ $data->pengantin_wanita->anggota_keluarga ? $data->kepala_keluarga->nama : $data->pengantin_wanita->nama_ayah }}</label>
                    </div>
                    <div class="form-group">
                        <label for="nama_ibu_pria">Nama Ibu : {{ $data->pengantin_wanita->anggota_keluarga ? $data->pasangan->nama : $data->pengantin_wanita->nama_ibu }}</label>
                    </div>
                </div>
            </div>
        </div>
        {{-- other --}}
        <div class="card" style="">
            <div class="card-body">
                <p style="font-size: 14px; font-weight: 600">Data Lainnya</p>
                <div class="form-group">
                    <label for="">Pemberkatan Hari, Tanggal, Jam : {{ Carbon\Carbon::parse($data->waktu_pernikahan, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</label>
                </div>
                <div class="form-group">
                    <label for="">Tempat Pernikahan : {{ $data->tmpt_pernikahan }}</label>
                </div>
                <div class="form-group">
                    <label for="">Alamat Setelah Menikah : {{ $data->alamat_setelah_menikah }}</label>
                </div>
            </div>
        </div>
    </div>
</body>
</html>