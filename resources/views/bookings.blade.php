@extends('layouts.standard')

@section('title', 'Bookings Page')

@section('content')

    <h1 class="mx-5">Bookings Page</h1>

    <div class='container-sm'>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Booking ID</th>
                    <th scope="col">Room ID</th>
                    <th scope="col">Booking Time</th>
                    <th scope="col">Booking Duration/minutes</th>
                    <th scope="col">Booker</th>
                    <th scope="col">Room Number</th>
                    <th scope="col">Building</th>
                    <th scope="col">Campus</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <th scope="row">{{ $booking->id }}</th>
                        <td>{{ $booking->room->id }}</td>
                        <td>{{ $booking->time_of_booking }}</td>
                        <td>{{ $booking->duration }}</td>
                        @if ( !is_null($booking->user_id)  )
                            <td>{{ $booking->user->name}} (user {{$booking->user->id}})</td>
                        @else
                            <td>Tablet Booking</td>
                        @endif
                        <td>{{ $booking->room->room_number }}</td>
                        <td>{{ $booking->room->building->name }}</td>
                        <td>{{ $booking->room->building->campus }}</td>
                        <td><button class="btn btn-success">Edit</button>  <button class='btn btn-danger'>Delete</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@endsection
