<div>



    {{-- If room is not currently in use --}}
    {{-- allow to book now --}}
    {{-- If room is currently in use --}}
    {{-- show other nearby avaialable rooms at this time --}}


    @php
        $in_use = false;
        $carbonTime = Carbon\Carbon::parse($time);
    @endphp




    @foreach ($bookings as $booking)
        @if (Carbon\Carbon::parse($booking->time_of_booking)->lte(Carbon\Carbon::parse($time)) and
                Carbon\Carbon::parse($booking->time_of_booking)->addMinutes($booking->duration)->gte(Carbon\Carbon::parse($time)))
            @php
                $in_use = true;
            @endphp
        @endif
    @endforeach






    @if (!$in_use)
        <div class="containter-fluid bg-success text-white">
            <div class = 'container-fluid'>
            <div class="row justify-content-center align-items-center g-2">
                <div class="col"><h1>Room Available</h1></div>
                <div class="col"><h1>{{$carbonTime->format('H:i')}}</h1></div>

            </div>
            
            <p></p>
            <div class="row justify-content-center align-items-center g-2">
                <div class="col">
                    <h3>Room Number: {{ $room->room_number }}</h3>
                </div>
                <div class="col">
                    <h3>Capacity: {{$room->capacity}}</h3>
                </div>
            </div>
            <div class="row py-5"></div>
            <div class="row justify-content-center align-items-center g-2">
                <h3>Facilities: 
                @foreach ($room->facilities as $facility)
                    <a class= "btn btn-warning btn-lg" href="">{{$facility->name}}</a>
                @endforeach
                </h3>
            </div>
            <div class="row bg-light py-5 border border-light"></div>
            <div class="row bg-light py-5 border border-light">
                <div class = 'col'><button class="btn btn-light btn-lg">15 mins</button></div>
                <div class = 'col'><button class="btn btn-light btn-lg">30 mins</button></div>
                <div class = 'col'><button class="btn btn-light btn-lg">45 mins</button></div>
                <div class = 'col'><button class="btn btn-light btn-lg">1 hour</button></div>
                <div class = 'col'><button class="btn btn-light btn-lg">1.5 hours</button></div>
                <div class = 'col'><button class="btn btn-light btn-lg">2 hours</button></div>
            </div>
            <div class="row bg-light py-5 border border-light"></div>

            {{-- when clicked area should pop up to show how long --}}
            <div class="row justify-content-center align-items-center g-2 py-5">
                <div class="col">
                    <button type="button" class="btn btn-danger btn-lg">Report Issue</button></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
            
        </div>
    @else
        <button type="button" class="btn btn-warning btn-lg">Check-in</button>
        <button type="button" class="btn btn-outline-warning btn-lg">Book Another Room Now</button>
    @endif
</div>
</div>
