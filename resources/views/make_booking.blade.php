@extends('layouts.standard')

@section('title', 'Make a Booking')
    
@section('content')
@livewire('booking-component', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'in_use' => false])
    
@endsection