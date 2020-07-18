<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('lib/datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Abel', sans-serif!important;
            background-color: #eaeaea;
        }
        .bg-light {
            background-color: #b9f6ca!important;
        }
        .navbar-light .navbar-nav .nav-link {
            color: #000;
        }
        .border-radius-0 {
            border-radius: 0;
        }
        .select2-container {
            width: 100%!important;
        }
        .select2-container--default .select2-selection--single {
            border: 0;
        }
        .form-control-xl {
            font-size: 32pt;
        }
    </style>
    @stack('styles')
    <title>@yield('title') {{ env('APP_NAME') }}</title>
</head>
<body>
    @auth
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <img src="{{ asset('img/logo.png') }}" width="30" height="30" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ Session::get('menu_active') == 'dashboard' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item dropdown {{ Session::get('menu_active') == 'master_data' ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Data Master</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('product_category') }}">Kategori Produk</a>
                                <a class="dropdown-item" href="{{ route('raw_material_category') }}">Kategori Bahan Baku</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('staff') }}">Karyawan</a>
                                <a class="dropdown-item" href="{{ route('customer') }}">Customer</a>
                            </div>
                        </li>
                        <li class="nav-item {{ Session::get('menu_active') == 'product' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('product') }}">Produk</a>
                        </li>
                        <li class="nav-item {{ Session::get('menu_active') == 'raw_material' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('raw_material') }}">Bahan Baku</a>
                        </li>
                        <li class="nav-item {{ Session::get('menu_active') == 'purchase' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('purchase') }}">Pembelian Bahan Baku</a>
                        </li>
                        <li class="nav-item {{ Session::get('menu_active') == 'transaction' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('transaction') }}">Penjualan</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endauth
    @yield('content')
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('lib/autoNumeric.js') }}"></script>
    <script src="{{ asset('lib/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.select2').select2();
        $('.autonumeric').attr('data-a-sep','.');
        $('.autonumeric').attr('data-a-dec',',');
        $('.autonumeric').autoNumeric({mDec: '0',vMax:'9999999999999999999999999', vMin: '-99999999999999999'});
        $('.autonumeric-decimal').attr('data-a-sep','.');
        $('.autonumeric-decimal').attr('data-a-dec',',');
        $('.autonumeric-decimal').autoNumeric({mDec: '2',vMax:'999'});
        $('.datepicker').datepicker({
            format:'dd-mm-yyyy',
            autoclose:true
        });
        function add_commas(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }
        function remove_commas(nStr) {
            nStr = nStr.replace(/\./g, '');
            return nStr;
        }
    </script>
    @stack('scripts')
</body>
</html>
