<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    @livewireStyles
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])


</head>
<title>@yield('title')</title>

<body>
    @if (\Session::has('message'))
    <div class="alert alert-success">
        <ul>
            {!! \Session::get('message') !!}
        </ul>
        @php
            header('Refresh:2');
        @endphp

    </div>
@endif
@if (\Session::has('error'))
    <div class="alert alert-danger">
        <ul>
            {!! \Session::get('error') !!}
        </ul>
        @php
            header('Refresh:2');
        @endphp

    </div>
@endif



    @livewireScripts

    

    
<div class = "container-fluid px-5">
    <img data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" src="/images/hamburger.png" alt="">
    <a href="/admin/bookings"class="badge rounded-pill bg-primary">Home</a>
    <a href="/dashboard" class="badge rounded-pill bg-primary">Account</a>

    @yield('content')
</div>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
          <h3 class="offcanvas-title" id="offcanvasScrollingLabel">Admin Pages</h3>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <a href="{{route('bookings.show')}}"><h5>Bookings</h5></a>
          <hr>
          <a href="{{route('users.index')}}"><h5>Users</h5></a>
          <hr>
          <a href="{{route('rooms.index')}}"><h5>Rooms</h5></a>
          <hr>
          <a href="{{route('permissions.index')}}"><h5>Permissions</h5></a>

        </div>
      </div>

</body>

</html>
