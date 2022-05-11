@extends('layouts.main')

@section('content-main')

    <h1 class="text-secondary">Оставить заявку</h1>
    <p>Заполните поля ниже, чтобы мы могли с Вами связаться</p>

    <x-order-form routeName="{{ $route_name }}"/>
   
@endsection