@extends('layouts.main')

@section('content-main')
    <h1 class="text-primary">Редактирование заявки</h1>

    <x-order-form routeName="{{$route_name}}" :order="$order" buttonText="Сохранить"/>
@endsection