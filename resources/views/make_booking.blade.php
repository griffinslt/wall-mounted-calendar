@extends('layouts.standard')

@section('title', 'Make a Booking')

@section('content')
    <div class = "container-fluid bg-secondary text-light">
        

</div>

    @livewire('booking-component', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings])
    
@endsection
