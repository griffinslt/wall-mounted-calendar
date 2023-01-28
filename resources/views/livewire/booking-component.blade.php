<div>
    <h1>Book Now</h1>


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
        <p>book now</p>
    @else
        <p>book another</p>
    @endif

</div>
