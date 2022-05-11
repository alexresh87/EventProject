@if(isset($order))
<form action="{{ route($routeName, ['id' => $order->id ]) }}" method="post">
@else
<form action="{{ route($routeName) }}" method="post">
@endif

    @csrf
    
    @foreach($inputs() as $input)
        <x-order-form.h6>{{ $input->title }}</x-form-order.h6>
        @foreach($input->items as $item)
            @if(isset($order))
                <x-order-form.input 
                    title="{{ $item->title }}" 
                    value="{{ $order->{$item->name} }}" 
                    name="{{ $item->name }}" 
                    id="floatingInput-{{ $item->name }}"
                />
            @else
                <x-order-form.input 
                    title="{{ $item->title }}" 
                    value="{{ $item->value }}" 
                    name="{{ $item->name }}" 
                    id="floatingInput-{{ $item->name }}"
                />
            @endif
        
        @endforeach
    @endforeach

    <x-order-form.footer value="{{$buttonText}}"/>
    {{ $slot }}
</form>