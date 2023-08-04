@extends('main')

@section('title')
    Login
@endsection

@section('content')
    <div style="margin: 3rem auto; width: 50%">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <p style="font-size: 20px; font-weight: 500">Login</p>
                </div>
                <form action="{{ route('auth.store.login') }}" method="post">
                    @csrf
                    {{-- <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" required class="form-control" name="email" value="{{ old('email') }}"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="email">
                    </div> --}}
                    <div class="form-group">
                        <label for="nip">NIP/Email</label>
                        <input type="text" required class="form-control" name="nip_email" value="{{ old('nip') }}"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="nip_email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" required class="form-control" name="password" value="{{ old('password') }}"
                            style="margin-top: 0.75rem; margin-bottom: 0.75rem" id="password">
                    </div>
                    <button class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection