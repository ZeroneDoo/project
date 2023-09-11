<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <h2>Data Baptis GBI (Gereja Bethel Indonesia)</h2>

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
            <label for="pendeta">Pendeta : {{ $data->pendeta }}</label>
        </div>
    </div>
</body>
</html>