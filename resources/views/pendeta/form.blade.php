@extends('main')

@section('title')
    {{ isset($data) ? 'Edit Pendeta' : 'Tambah Pendeta' }}
@endsection

@section('content')
<div style="margin: 3rem auto; width: 91%; ">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ isset($data) ? 'Edit Pendeta' : 'Tambah Pendeta' }}</h5>
            <form method="POST" action="{{ isset($data) ? route('pendeta.update', $data->id) :  route('pendeta.store') }}" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                    @method("patch")
                @endif
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="nama">Nama Pendeta</label>
                            <input type="text" required autocomplete="off" value="{{ isset($data) ? $data->nama : old('nama') }}" name="nama" class="form-control" id="nama">
                            @error('nama')
                            <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="cabang">Cabang</label>
                            <select name="cabang_id" class="form-select" id="cabang">
                                <option value="" hidden selected>Pilih Cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                                @endforeach
                            </select>
                            @error('cabang')
                            <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama">Foto Pendeta</label>
                    <input type="file" accept="image/*" required name="foto" class="form-control" id="foto">
                    @error('foto')
                    <small style="color: red">{{ $message }}</small>
                    @enderror
                    @isset($data)
                        <img src="{{ asset('storage/'.$data->foto) }}" alt="" style="width: 300px; height: 200px; object-fit: cover">
                    @endisset
                </div>
                <div class="mt-4" style="margin-top: 0.75rem; display: flex; gap: 5px">
                    <a href="{{ route('pendeta.index') }}" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Ubah' : 'Buat Baru' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
