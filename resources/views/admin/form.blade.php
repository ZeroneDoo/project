@extends('main')

@section('title')
    {{ isset($data) ? 'Edit Admin' : 'Tambah Admin' }}
@endsection

@section('content')
<div style="margin: 3rem auto; width: 91%; margin-bottom: 10rem;">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ isset($data) ? 'Edit Admin' : 'Tambah Admin' }}</h5>
            <form method="POST" action="{{ isset($data) ? route('user.update', $data->id) : route('user.store') }}">
                @csrf
                @if (isset($data))
                @method('patch')
                @endif
                <div class="form-group">
                    <label for="nama">Nama Admin</label>
                    <input type="text" autocomplete="off" value="{{ isset($data) ? $data->nama : old('nama') }}" name="nama" class="form-control" id="nama">
                    @error('nama')
                    <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="number" autocomplete="off" value="{{ isset($data) ? $data->nip : old('nip') }}" name="nip" class="form-control" id="nip">
                    @error('nip')
                    <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" autocomplete="off" value="{{ isset($data) ? $data->email : old('email') }}" name="email" class="form-control" id="email">
                    @error('email')
                    <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
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
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select name="role_id" id="role_id" class="form-select">
                        <option value="" selected hidden>Pilih Role</option>
                        @foreach ($roles as $role)
                        <option {{ isset($data) ? ($data->role_id == $role->id ? 'selected' : '') : '' }} value="{{ $role->id }}">{{ $role->nama }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                    <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" value="{{ old('password') }}" name="password" class="form-control" id="password">
                    @error('password')
                    <small style="color: red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mt-4" style="margin-top: 0.75rem; display: flex; gap: 5px">
                    <a href="{{ route('user.index') }}" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{ isset($data) ? 'Ubah' : 'Buat Baru' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
