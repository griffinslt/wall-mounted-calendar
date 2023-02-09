@extends('layouts.admin')

@section('title', 'Bookings Page')

@section('content')


    <h1 class="mx-5">Bookings Page</h1>

    <div class='container-fluid'>
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
                        <td><button class="btn btn-success">Edit</button> 
                            <button data-bs-target="#deleteModal"
                            data-bs-toggle="modal" data-url="{{route('bookings.destroy', ['booking' => $booking->id])}}"
                            class='btn btn-danger delete-booking'>Delete</button>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this booking?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form action="" method="post" id="deleteForm">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger"> Delete Booking </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // For A Delete Record Popup
            $('.delete-booking').click(function() {
                var url = $(this).attr('data-url');
                console.log(url);
                $("#deleteForm").attr("action", url);
            });
        });
    </script>




@endsection
