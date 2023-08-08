@extends('main')

@section('title')
Pendeta
@endsection

@section('content')
<div style="margin: 3rem auto; width: 91%">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <a href="{{ route('pendeta.create') }}" class="btn btn-primary">Tambah Pendeta</a>
            </div>
            <div style="overflow: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Dibuat</th>
                            <th>Diubah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $i => $data)
                        <tr>
                            <td>{{ $i + $datas->FirstItem() }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->created_at->diffForHumans() }}</td>
                            <td>{{ $data->updated_at->diffForHumans() }}</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a href="{{ route('pendeta.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('pendeta.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 0.75rem; width: 100%">
                {{ $datas->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection