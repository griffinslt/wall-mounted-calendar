@extends('layouts.tablet')

@section('title', 'Make a Booking')

@section('content')
    <div class="container-fluid bg-secondary text-light">


    </div>

    @livewire('booking-component', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings])

    <div class="modal text-black" id="reportIssueModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">What problem is there with the room?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href = "{{route('booking.submit-issue', ['room'=>$room, 'issue' =>'Faulty Lights'])}}" class='btn btn-info btn-lg'>Faulty
                        Lights</a>
                    <hr>
                    <a href = "{{route('booking.submit-issue', ['room'=>$room, 'issue' =>'WiFi Not Working'])}}" class='btn btn-info btn-lg'>WiFi Not
                        Working</a>
                    <hr>
                    <a href = "{{route('booking.submit-issue', ['room'=>$room, 'issue' =>'Broken Chairs'])}}" class='btn btn-info btn-lg'>Broken
                        Chairs</a>
                    <hr>
                    <a href = "{{route('booking.submit-issue', ['room'=>$room, 'issue' =>'Missing Chairs'])}}" class='btn btn-info btn-lg'>Missing Chairs</a>
                    <hr>
                    <a href = "{{route('booking.submit-issue', ['room'=>$room, 'issue' =>'Broken Table'])}}" class='btn btn-info btn-lg'>Broken Table</a>
                    <hr>
                    <a href = "{{route('booking.submit-issue', ['room'=>$room, 'issue' =>'Missing Tables'])}}" class='btn btn-info btn-lg'>Missing Tables</a>
                    <hr>
                    <a data-bs-target="#problemWithFacilitiesModal" data-bs-toggle="modal"
                        class='btn btn-primary btn-lg'>Problem With Facilities</a>
                    <hr>
                    <h5>Any other problems, email support@univeristy.com</h5>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade text-black" id="problemWithFacilitiesModal" tabindex="-1" aria-labelledby="exampleModalLabel2"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel2">What facility is the problem with?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($room->facilities as $facility)
                        <a href ="{{route('booking.submit-issue', ['room'=>$room, 'issue' =>$facility->name])}}"class='btn btn-info btn-lg'>{{ $facility->name }}</a>
                        <hr>
                    @endforeach
                    <h5>Any other problems, email support@univeristy.com</h5>
                </div>
                <div class="modal-footer">
                    <button data-bs-target="#reportIssueModal" data-bs-toggle="modal" type="button" class='btn btn-primary btn-lg '>Go back</button>
                </div>
            </div>
        </div>
    </div>


@endsection
