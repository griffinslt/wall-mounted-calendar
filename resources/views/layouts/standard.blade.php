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
    @livewire('livewire-ui-modal')
    @livewireScripts
    

    @yield('content')






    
    
</body>

</html>
