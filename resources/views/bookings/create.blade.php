@extends('layouts.standard')

@section('title', 'Create Booking Page')

@section('content')


    <h1 class="mx-5">Make a booking in {{$building->name}} ({{$building->campus}})</h1>

    <div class="container-fluid px-5">
    <form method="POST" action="{{route('admin.bookings.store')}}">
        @csrf
        <div class="form-floating">
            <select name="room_id" class="form-select">
                @foreach ($building->rooms->sortBy('floor') as $room)
                    
                    <option value={{$room->id}}>{{$room->room_number}} (floor {{$room->floor}}) </option>
                @endforeach
                
                
            </select>
            <label form="floatingSelect">Room</label>
        </div>

        <hr>
        <div class="form-floating">
            <select name="duration" class="form-select" id="floatingSelect" aria-label="Floating label select example">

                <option value="15">15 Minutes</option>
                <option value="30">30 Minutes</option>
                <option value="45">45 Minutes </option>
                <option value="60">1 Hour</option>
                <option value="90">1.5 Hours</option>
                <option value="120">2 Hours</option>
            </select>
            <label form="floatingSelect">Duration</label>
        </div>
        <hr>





        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <div class="form-floating">
                    <select name="day" class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        @for ($i = 0; $i < 31; $i++)
                            <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                        @endfor
                    </select>
                    <label form="floatingSelect">Day</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <select name="month" class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        @for ($i = 0; $i < 12; $i++)
                            <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                        @endfor
                    </select>
                    <label form="floatingSelect">Month</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <select name="year" class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        <option value="{{ Carbon\Carbon::now()->format('Y') }}"> {{ Carbon\Carbon::now()->format('Y') }}
                        </option>
                        <option value="{{ Carbon\Carbon::now()->addYears(1)->format('Y') }}">
                            {{ Carbon\Carbon::now()->addYears(1)->format('Y') }}</option>
                    </select>
                    <label form="floatingSelect">Year</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <select name="hour" class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        @for ($i = 8; $i < 21; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <label form="floatingSelect">Hour</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <select name="minute" class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        @for ($i = 0; $i < 60; $i += 15)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <label form="floatingSelect">Minute</label>
                </div>
            </div>
        </div>




        <p></p>
        <input type="submit" value="Submit" class="btn btn-primary">

        <a class="btn btn-danger" href="/bookings">Cancel</a>
    </form>
    <p></p>
    <h4>Wrong Building?</h4>
    <p>Click <a href="{{route('bookings.chooseBuilding')}}">Here</a></p>
</div>






@endsection
