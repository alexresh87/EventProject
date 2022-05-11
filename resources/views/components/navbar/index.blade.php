<nav class="navbar navbar-expand-md navbar-dark bg-dark">
<div class="container-fluid">
    <x-navbar.header>
        @auth
            <x-navbar.auth/>
        @else
            <x-navbar.guest/>
        @endauth
    </x-navbar.header>
</div>
</nav>
