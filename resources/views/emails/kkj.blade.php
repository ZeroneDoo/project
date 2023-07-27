<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- bootstrap --}}
    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <title>Document</title>
</head>
<body>
    <h2>Kartu Keluarga Jemaat GBI (Gereja Bethel Indonesia)</h2>

    <p style="font-size: 14px;">Kode Kartu Keluarga: <span style="font-weight: bold;">{{ $data->kode }}</span></p>

    <div>
        {{-- data umum --}}
        <div class="card">
            <div class="card-body">
                <div>
                    <label for="email">Email : {{ $data->email }}</label>
                </div>
                <div>
                    <label for="alamat">Alamat : {{ $data->alamat }}</label>
                </div>
                <div>
                    <label for="rt_rw">RT/RW : {{ $data->rt_rw }}</label>
                </div>
                <div>
                    <label for="telp">No Telepon : {{ $data->telp }}</label>
                </div>
                <div>
                    <label for="provinsi">Provinsi : {{ $data->provinsi }}</label>
                </div>
                <div>
                    <label for="kabupaten">Kabupaten/Kota : {{ $data->kabupaten }}</label>
                </div>
                <div>
                    <label for="kecamatan">Kecamatan : {{ $data->kecamatan }}</label>
                </div>
                <div>
                    <label for="status_menikah">Status Menikah : {{ $data->status_menikah }}</label>
                </div>
            </div>
        </div>
        {{-- data anggota --}}
        <div class="row" style="margin-top: 1.5rem">
            {{-- kepala keluarga --}}
            <div class="col-sm mb-3" id="card_kepala_keluarga" hidden>
                <div class="card">
                    <div class="card-body">
                        <p style="margin-bottom: 1.5rem; font-weight: 600; font-size: 14px">Kepala Keluarga</p>
                        <div>
                            <label for="nama_kepala_keluarga">Nama Lengkap : {{ $data->kepala_keluarga->nama }}</label>
                        </div>
                        <div class="div">
                            <label for="nama_kepala_keluarga">Jenis Kelamin : {{  $data->kepala_keluarga->jk == "L"? "Laki Laki":"Perempuan" }}</label>
                        </div>
                        <div>
                            <label for="tmpt_lahir">Tempat Lahir : {{ $data->kepala_keluarga->tmpt_lahir }}</label>
                        </div>
                        <div>
                            <label for="tgl_lahir">Tanggal Lahir : {{ $data->kepala_keluarga->tgl_lahir }}</label>
                        </div>
                        <div>
                            <label for="pendidikan_terakhir">Pendidikan Terakhir : {{ $data->kepala_keluarga->pendidikan_terakhir }}</label>
                        </div>
                        <div>
                            <label for="pekerjaan">Pekerjaan : {{ $data->kepala_keluarga->pekerjaan }}</label>
                        </div>
                        <div>
                            <label for="baptis_date">Baptis Selam : {{ $data->kepala_keluarga->baptis }}</label>
                        </div>
                    </div>
                </div>
            </div>
            {{-- pasangan --}}
            @if (isset($data->pasangan) && isset($data))
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <p style="margin-bottom: 1.5rem;font-weight: 600; font-size: 14px">Pasangan</p>
                        <div>
                            <label for="nama_pasangan">Nama Lengkap : {{ $data->pasangan->nama }}</label>
                        </div>
                        <div>
                            <label for="">Jenis Kelamin : {{  $data->pasangan->jk == "L"? "Laki Laki":"Perempuan" }}</label>
                        </div>
                        </div>
                        <div>
                            <label for="tmpt_lahir_pasangan">Tempat Lahir : {{ $data->pasangan->tmpt_lahir }}</label>
                        </div>
                        <div>
                            <label for="tgl_lahir_pasangan">Tanggal Lahir : {{ $data->pasangan->tgl_lahir }}</label>
                        </div>
                        <div>
                            <label for="pendidikan_terakhir_pasangan">Pendidikan Terakhir : {{ $data->pasangan->pendidikan_terakhir }}</label>
                        </div>
                        <div>
                            <label for="pekerjaan_pasangan">Pekerjaan : {{ $data->pasangan->pekerjaan }}</label>
                        </div>
                        <div>
                            <label for="baptis_date_pasangan">Baptis Selam : {{ $data->pasangan->baptis }}</label>
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
                            <p style="font-size: 14px; font-weight: 600;">Data Anak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4" style="margin-bottom: 0.75rem;" id="card_anak">
            @if (count($data->anak) <= 0)
            <div>
                <label>-</label>
            </div>
            @endif
            @if (isset($data))
                @foreach ($data->anak as $i => $anak)
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <p style="font-size: 14px; font-weight: bold">{{ $anak->nama }}</p>
                            <div>
                                <label for="nama_anak_edit">Nama Lengkap : {{ $anak->nama }}</label>
                            </div>
                            <div>
                                <label for="nama_anak_edit">Jenis Kelamin : {{  $anak->jk == "L"? "Laki Laki":"Perempuan" }}</label>
                            </div>
                            <div>
                                <label for="tmpt_lahir_anak_edit">Tempat Lahir : {{ $anak->tmpt_lahir }}</label>
                            </div>
                            <div>
                                <label for="tgl_lahir_anak_edit">Tanggal Lahir : {{ $anak->tgl_lahir }}</label>
                            </div>
                            <div>
                                <label for="pendidikan_anak_edit">Pendidikan : {{ $anak->pendidikan }}</label>
                            </div>
                            <div>
                                <label for="pekerjaan_anak_edit">Pekerjaan : {{ $anak->pekerjaan }}</label>
                            </div>
                            <div>
                                <label for="diserahkan_anak_edit">Diserahkan : {{ $anak->diserahkan == 'Y' ? 'Iya' : 'Tidak' }}</label>
                            </div>
                            <div>
                                <label for="baptis_anak_edit">Baptis Selam : {{ $anak->baptis == 'Y' ? 'Iya' : 'Tidak' }}</label>
                            </div>
                            <div>
                                <label for="nikah_anak_edit">Nikah : {{ $anak->nikah == 'Y' ? 'Iya' : 'Tidak' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        {{-- keluarga --}}
        <div style="margin-bottom: 1.25rem" id="anak">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-center justify-content-between">
                        <div class="flex-item">
                            <p style="font-size: 14px; font-weight: 600;">Data Keluarga/Orang Lain yang Tinggal Serumah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4" id="card_keluarga">
            {{-- list --}}
            {{-- ajax --}}
            @if (count($data->keluarga) <= 0)
            <div>
                <label>-</label>
            </div>
            @endif
            @if (isset($data))
                @foreach ($data->keluarga as $i => $keluarga)
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <p style="font-size: 14px; font-weight: 600">{{ $keluarga->nama }}.</p>
                            <div>
                                <label>Nama Lengkap : {{ $keluarga->nama }}</label>
                            </div>
                            <div>
                                <label>Jenis Kelamin : {{  $keluarga->jk == "L"? "Laki Laki":"Perempuan" }}</label>
                            </div>
                            <div>
                                <label>Tempat Lahir : {{ $keluarga->tmpt_lahir }}</label>
                            </div>
                            <div>
                                <label>Tanggal Lahir : {{ $keluarga->tgl_lahir }}</label>
                            </div>
                            <div>
                                <label>Pendidikan : {{ $keluarga->pendidikan }}</label>
                            </div>
                            <div>
                                <label>Pekerjaan : {{ $keluarga->pekerjaan }}</label>
                            </div>
                            <div>
                                <label>Diserahkan : {{ $keluarga->diserahkan == 'Y' ? 'Iya' : 'Tidak' }}</label>
                            </div>
                            <div>
                                <label>Baptis Selam : {{ $keluarga->baptis == 'Y' ? 'Iya' : 'Tidak' }}</label>
                            </div>
                            <div>
                                <label>Nikah : {{ $keluarga->nikah == 'Y' ? 'Iya' : 'Tidak' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        {{-- urgent --}}
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <p style="font-size: 14px; font-weight: 600;">Keadaan Darurat/Penting</p>
                </div>
                <div>
                    <label for="nama_urgent">Nama/Keluarga : {{ $data->urgent->nama }}</label>
                </div>
                <div>
                    <label for="alamat_urgent">Alamat : {{ $data->urgent->alamat }}</label>
                </div>
                <div>
                    <label for="telp_urgent">No Telpon : {{ $data->urgent->telp }}</label>
                </div>
                <div>
                    <label for="hubungan_urgent">Hubungan : {{ $data->urgent->hubungan }}</label>
                </div>
            </div>
        </div>
    </div>
</form> 
</body>
</html>