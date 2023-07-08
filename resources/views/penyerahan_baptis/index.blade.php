@extends('main')

@section('title')
Form Penyerahan & Baptis
@endsection

@section('content')
<form action="{{ route('penyerahan-baptis.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div style="margin: 3rem auto; width: 91%">
        <div class="card" style="margin-bottom: 1rem">
            <div class="card-body">
                <div class="card-title mx-auto" style="width: fit-content"><p style="font-size: 20px; font-weight: 500;">Penyerahan/Baptis Air</p></div>
                <div class="input-group" style="margin-bottom: 1rem;  margin-left: auto;margin-right: auto;">
                    <input type="text" placeholder="Kode Kartu Keluarga" value="{{ old('search') }}" class="form-control" name="search" id="search">
                    <select name="hubungan" id="hubungan" class="form-select">
                        <option value="anak">Anak</option>
                        <option value="keluarga">Keluarga</option>
                    </select>
                    <button class="btn btn-primary" type="button" onclick="Component.searchKkj({route: '{{ route('penyerahan-baptis.searchkkj') }}', token: '{{ csrf_token() }}'})">Search</button>
                </div>  
                <div class="form-group" hidden id="select-keluarga-anak" style="margin-top: 1.75rem">
                    <select name="id" class="form-select mx-auto" id="keluarga_anak_id" onchange="Component.getDataKandidat({route:'{{ route('penyerahan-baptis.getKandidat') }}',select:this, token:'{{ csrf_token() }}'})">
                        {{-- ajax --}}
                    </select>
                </div>
            </div>
        </div>
        {{-- form --}}
        <div class="card" id="card_penyerahan_baptis" hidden style="margin-bottom: 1rem">
            <div class="card-body">
                {{-- data kandidat --}}
                <div id="data_kandidat">
                    {{-- ajax --}}
                    <input type="hidden" value="{{ isset($data) ? $data->id :'' }}" id="id_relasi" name="id_relasi">
                    {{-- <input type="hidden" value="{{ isset($data) ? $hubungan : '' }}" id="hubungan" name="hubungan"> --}}
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" disabled value="{{ isset($data) ? $data->nama: '' }}" name="nama" class="form-control">
                            </div>
                            <div class="col-5">
                                <input type="text" disabled value="{{ isset($data) ? $data->jk: '' }}" name="jk" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" disabled>{{ isset($data) ? $data->alamat : ''}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir">Tempat & Tanggal Lahir</label>
                        <input type="text" class="form-control" disabled value="{{ isset($data) ? $data->tmpt_lahir .' '. $data->tgl_lahir : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Ayah</label>
                        <input type="text" disabled class="form-control" value="{{ isset($data) ? $data->kkj_kepala_keluarga->nama :'' }}">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Ibu</label>
                        <input type="text" disabled class="form-control" value="{{ isset($data) ? $data->kkj_pasangan->nama :'' }}">
                    </div>
                </div>
                {{-- /data kandidat --}}
                <div class="form-group">
                    <label for="waktu">Tanggal Baptis/Penyerahan</label>
                    <input type="datetime-local" class="form-control" name="waktu" id="waktu" required>
                </div>
                <div class="form-group">
                    <label for="pendeta">Pendeta</label>
                    <input type="text" class="form-control" id="pendeta" name="pendeta" required>
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto" required>
                </div>
                <div class="mt-4 mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="baptis" id="baptis">
                        <label for="baptis">Baptis</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="penyerahan" id="penyerahan">
                        <label for="penyerahann">Penyerahan</label>
                    </div>
                </div>
                <button class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
    <script>
        // $("#keluarga_anak_id").select2({
        //     placeholder: "Pilih Keluarga/Anak",
        // });
    </script>
@endpush