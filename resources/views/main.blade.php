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

    {{-- Jquery --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    {{-- Select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- alert --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

    {{-- tom select --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    
    {{-- Js --}}
    <script src="{{ asset('assets/js/index.js') }}"></script>

    @stack('css')

    <title>@yield('title')</title>
</head>

<body>
    @if (Auth::check())
        <div class="p-4 mb-4" style="display: flex; align-items: center; justify-content: {{  !Request::is('dashboard*') ? 'space-between' : 'end' }}; gap:30px; border-bottom: 1px black solid">
            @if (!Request::is('dashboard*'))
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                </div>
            @endif
            <div style="display: flex; align-items: center; gap:30px">
                <p>{{ Auth::user()->nama." || ". Auth::user()->role->nama }}</p>
                <a href="{{ route('auth.logout') }}" class="btn btn-danger">Logout</a>
            </div>
        </div>
    @endif
    @yield('content')
    @stack('js')

    @if (Session::has('msg_error'))
        <script>
            Component.showAlert("{{ Session::get('msg_error') }}", 'error')
        </script>
    @elseif(Session::has('msg_success'))
        <script>
            Component.showAlert("{{ Session::get('msg_success') }}", 'success')
        </script>
    @elseif(Session::has('msg_info'))
        <script>
            Component.showAlert("{{ Session::get('msg_info') }}", 'info')
        </script>
    @endif
</body>

</html>
