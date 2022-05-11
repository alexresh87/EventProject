<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>@yield('login-title')</title>
</head>
<body class="form-auth-body text-center bg-dark text-white">
    @include('inc.requestStatus')
    @yield('content')
    
    <main class="form-auth">
        @yield('content-login')
        <p class="mt-5 mb-3 text-muted">{{ __('messages.companyName') }}</p>
    </main>

</body>
</html>