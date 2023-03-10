@can('setup-tablet')
    @extends('layouts.tablet')

    @section('title', 'Setup Tablet')


@section('content')
    <div class="container-fluid p-5">
        <h1>The process to set up a tablet is the following...</h1>
        <h5>
        <ul>
            <li>Choose which room you want to setup the tablet for</li>
            <li>Generate a Cookie</li>
            <li>You are logged out</li>
            <li>Redirected to the tablet Page</li>
        </ul>
    </h5>

        @livewire('tablet-setup-form', ['rooms' => $rooms, 'buildings' => $buildings])

        <a href="{{route('get-cookie')}}">check</a>

    </div>

@endsection
@endcan
