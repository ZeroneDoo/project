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
                <label for="nama">Nama : {{  $data->nama }}</label>
            </div>
            <div>
                <label for="nama">Jenis Kelamin : {{  $data->jk == "L"? "Laki Laki":"Perempuan" }}</label>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat : {{  $data->kkj->alamat }}</label>
            </div>
            <div class="form-group">
                <label for="tmpt_lahir">Tempat & Tanggal Lahir : {{  $data->tmpt_lahir .', '. Carbon\Carbon::parse($data->tgl_lahir, 'Asia/Jakarta')->translatedFormat('d F Y') }}</label>
            </div>
            <div class="form-group">
                <label for="">Nama Ayah : {{  $data->kkj_kepala_keluarga->nama }}</label>
            </div>
            <div class="form-group">
                <label for="">Nama Ibu : {{  $data->kkj_pasangan ? $data->kkj_pasangan->nama : 'Tidak Ada' }}</label>
            </div>
        </div>
        {{-- /data kandidat --}}
        <div class="form-group">
            <label for="waktu">Tanggal Baptis : {{ Carbon\Carbon::parse($data->baptiss->waktu, 'Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}</label>
        </div>
        <div class="form-group">
            <label for="pendeta">Pendeta : {{ $data->baptiss->pendeta }}</label>
        </div>
    </div>
</body>
</html>