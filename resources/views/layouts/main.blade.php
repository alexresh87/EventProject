<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>

    <script src="{{ mix('js/app.js') }}"></script>

    @if(Route::currentRouteName() == 'dashboard')
        <script src="{{ mix('js/charts.js') }}"></script>
    @endif
    
    <title>@yield('login-title')</title>
</head>
<body class="body-main bg-dark mx-auto text-white">

    <x-navbar/>
    
    <div class="container mt-6">
        <div class="row">
            @include('inc.requestStatus')
            
            @yield('content-main')
        </div>
    </div>
</body>
</html>