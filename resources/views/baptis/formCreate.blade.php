@extends('main')

@section('title')
    Buat Baptis
@endsection

@section('content')
<form action="{{ route('baptis.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div style="margin: 3rem auto; width: 91%">
        <div class="card" style="margin-bottom: 1rem">
            <div class="card-body">
                <div class="card-title mx-auto" style="width: fit-content"><p style="font-size: 20px; font-weight: 500;">Baptis</p></div>
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
                </div>
                {{-- /data kandidat --}}
                <div class="form-group">
                    <label for="waktu">Tanggal Baptis</label>
                    <input type="datetime-local" class="form-control" name="waktu" id="waktu" required>
                </div>
                <div class="form-group">
                    <label for="pendeta">Pendeta</label>
                    <select name="pendeta" id="" class="form-select" required>
                        <option value="">Select Pendeta</option>
                        @foreach ($pendetas as $pendeta)
                            <option value="{{ $pendeta->id }}" {{ isset($data) ? ($pendeta->id == $data->pendeta_id ? "selected" : "") : "" }}>{{ $pendeta->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto" required>
                </div>
                <button class="btn btn-primary">Submit</button>
                <a href="{{ route('baptis.index') }}" class="btn btn-danger" style="margin-top: 1rem">Back</a>
            </div>
        </div>
    </div>
</form>
@endsection