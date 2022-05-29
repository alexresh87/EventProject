<nav class="navbar navbar-expand-md navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand" href="#">{{ __('messages.companyName') }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav me-auto mb-2 mb-md-0">
        @auth
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Главная</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('order.get') }}">Запросы клиентов</a>
        </li>
        @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('order.create') }}">Создать запрос</a>
        </li>
        @endauth
    </ul>
    <div class="d-flex">
        @auth
            <a href="{{ route('auth.logout') }}" class="btn btn-secondary">Выйти</a>
        @else
            <a href="{{ route('auth.login') }}" class="btn btn-primary">Войти</a>
        @endauth
    
    </div>
</div>
</nav>
