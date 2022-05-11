@extends('layouts.auth')

@section('content-login')
    <form method="post" action="{{ route('auth.login') }}">
        @csrf 
        <h1 class="h3 mb-3 fw-normal">Вход</h1>

        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Введите E-mail">
            <label for="floatingInput">Email адрес</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Введите пароль">
            <label for="floatingPassword">Пароль</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" value="remember-me"> Запомнить меня
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
        
    </form>
@endsection