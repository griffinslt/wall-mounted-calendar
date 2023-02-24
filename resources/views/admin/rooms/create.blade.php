@extends('layouts.admin')

@section('title', 'Create Room')

@section('content')
    <div class="container-fluid px-5">
        <h1>Create Room</h1>
        <p></p>
        <form method="POST" action="{{route('rooms.store')}}">
            @csrf
            <div class="row">
                <div class='col'>
                    <h5>Capacity:</h5>
                </div>
                <div class="col"><input type="text" name="capacity" value=""></div>
                <div class="col"></div>
                <div class="col"></div>
                <p></p>
            </div>
            <div class="row">
                <div class='col'>
                    <h5>Room Number: </h5>
                </div>
                <div class='col'><input type="text" name="room_number" value=""></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
            <p></p>

            <div class="row">
                <div class="col">
                    <h5>Floor: </h5>
                </div>
                <div class="col"><input type="text" name="floor" value=""></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>

            <p></p>
            <div class="form-floating">
                <select name="building" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                    @foreach ($buildings as $building)
                        
                            <option value="{{ $building->id }}">{{ $building->name }} ({{ $building->campus }})</option>

                    @endforeach

                </select>
                <label form="floatingSelect">Building</label>

            </div>
            <p></p>



            <p></p>
            <input type="submit" value="Submit" class="btn btn-primary">
            <a class="btn btn-danger" href="/admin/rooms">Cancel</a>
        </form>


    </div>





@endsection
