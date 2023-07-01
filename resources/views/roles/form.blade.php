@extends('main')

@section('title')
    {{ isset($data) ? 'Edit Role' : 'Tambah Role' }}
@endsection

@section('content')
<div style="margin: 3rem auto; width: 91%">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ isset($data) ? 'Edit Role' : 'Tambah Role' }}</h5>
            <form method="POST" action="{{ route('role.store') }}">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Role</label>
                    <input type="text" autocomplete="off" value="{{ isset($data) ? $data->nama : old('nama') }}" name="nama" class="form-control" id="nama">
                    @error('nama')
                    <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div style="margin-top: 0.75rem; display: flex; gap: 5px">
                    <a href="{{ route('role.index') }}" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Ubah' : 'Buat Baru' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
