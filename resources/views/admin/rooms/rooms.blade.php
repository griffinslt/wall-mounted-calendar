@extends('layouts.admin')

@section('title', 'Rooms Page')

@section('content')


<div class="row px-5">
    <div class="col"><h1>Rooms Page</h1></div>
    <div class="d-flex justify-content-end col"><a href="{{route('rooms.create')}}">Create Room</a>
    </div>
</div>

    <div class='container-fluid px-5'>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Room ID</th>
                    <th scope="col">Room Number</th>
                    <th scope="col">Floor Number</th>
                    <th scope="col">Building</th>
                    <th scope="col">Campus</th>
                    <th scope="col">Capacity</th>
                    <th scope="col">Facilities</th>
                    <th scope="col">Bookings</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr>
                        <th scope="row">{{ $room->id }}</th>
                        <td>{{ $room->room_number }}</td>
                        <td>{{ $room->floor }}</td>
                        <td>{{ $room->building->name }}</td>
                        <td>{{ $room->capacity }}</td>
                        <td>{{ $room->building->name }}</td>
                        <td>
                        @foreach ($room->facilities as $facility)
                            <p>{{$facility->name}}</p>
                        @endforeach
                    </td>
                        <td><a href = "{{route('bookings.index-for-room', ['room' => $room->id])}}" class= "btn btn-info">Bookings</a></td>
                        <td><a href="{{route('rooms.edit', ['room' => $room->id])}}" class="btn btn-success">Edit</a> 
                            <button data-bs-target="#deleteModal"
                            data-bs-toggle="modal" data-url="{{route('rooms.destroy', ['room' => $room->id])}}"
                            class='btn btn-danger delete-booking'>Delete</button>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$rooms->links()}}
    </div>


    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this room?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form action="" method="post" id="deleteForm">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger"> Delete Room </button>
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
