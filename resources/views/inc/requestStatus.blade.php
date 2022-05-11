@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if( Session::has('error_message') )
    <div class="alert alert-danger">
        {{ Session::get('error_message') }}
    </div>
@endif

@if( Session::has('success_message') )
    <div class="alert alert-success">
        {{ Session::get('success_message') }}
    </div>
@endif