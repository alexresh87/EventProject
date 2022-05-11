@extends('layouts.main')

@section('content-main')
    <h1 class="text-secondary mb-5">Список вопросов</h1>

    <form action="{{ route('order.get') }}" method="get">
        <input type="text" name="search" placeholder="Введите Фамилию, имя или телефон для поиска записей" class="form-control" value="{{ $search }}">
    </form>

    <table class="table table-dark table-hover mt-1">
        <tr>
            <th></th>
            <th>ФИО</th>
            <th>Город</th>
            <th>Адрес</th>
            <th>Телефон</th>
            <th>E-mail</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>@onlydate($order->created_at)</td>
            <td><a href="{{ route('order.update',['id' => $order->id]) }}">{{ $order->lastname }} {{ $order->firstname }} {{ $order->patronymic }}</a></td>
            <td>{{ $order->city }}</td>
            <td>{{ $order->address }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->email }}</td>
        </tr>
        @endforeach
    </table>
    {{ $orders->links() }}
    <p>Всего найдено записей: {{ $count_orders }}</p>

@endsection