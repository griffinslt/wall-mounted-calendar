@extends('layouts.admin')

@section('title', 'Edit Room')

@section('content')
    <div class="container-fluid px-5">
        <h1>Edit Room: {{ $room->id }}</h1>
<p></p>
        <form method="POST" action="{{route('rooms.update', ['room' => $room])}}">
            @csrf
            <div class="row">
                <div class='col'>
                    <h5>Capacity:</h5>
                </div>
                <div class="col"><input type="text" name="capacity" value="{{ $room->capacity }}"></div>
                <div class="col"></div>
                <div class="col"></div>
<p></p>
            </div>
            <div class="row">
                <div class='col'>
                    <h5>Room Number: </h5>
                </div>
                <div class='col'><input type="text" name="room_number" value="{{ $room->room_number }}"></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
<p></p>

            <div class="row">
                <div class="col">
                    <h5>Floor: </h5>
                </div>
                <div class="col"><input type="text" name="floor" value="{{ $room->floor }}"></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>

            <p></p>
            <div class="form-floating">
                <select name="building" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                    @foreach ($buildings as $building)
                        @if ($building->id == $room->building->id)
                            <option selected="selected" value="{{ $building->id }}">{{ $building->name }}
                                ({{ $building->campus }})
                            </option>
                        @else
                            <option value="{{ $building->id }}">{{ $building->name }} ({{ $building->campus }})</option>
                        @endif
                    @endforeach

                </select>
                <label form="floatingSelect">Building</label>

            </div>
            <p></p>
            <h5>Facilities:</h5>
            <div class="row">
                @foreach ($room->facilities as $facility)
                    <div class="col">
                        <div class="badge bg-warning text-wrap text-black fw-normal fs-5">{{ $facility->name }}</div>
                        <a class="btn btn-danger btn-sm" href="{{route('rooms.remove-facility', ['room'=>$room->id, 'facility'=>$facility->id])}}">Remove</a>
                    </div>
                @endforeach
            </div>
            <p></p>
            <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle fs-5" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Add a facility
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach ($facilities as $facility)
                        <li><a class="dropdown-item" href="{{route('rooms.add-facility', ['room'=>$room->id, 'facility'=>$facility->id])}}">{{ $facility->name }}</a></li>
                    @endforeach

                </ul>
            </div>


            <p></p>
            <input type="submit" value="Submit" class="btn btn-primary">
            <a class="btn btn-danger" href="/admin/rooms">Cancel</a>
        </form>


    </div>





@endsection
