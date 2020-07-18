<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8"/>
    <title>@yield('title')Print</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
    @stack('styles')
</head>
<body>
@yield('content')
@stack('scripts')
</body>
</html>
