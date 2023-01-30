<div wire:poll.1000ms>
    {{-- If room is not currently in use --}}
    {{-- allow to book now --}}
    {{-- If room is currently in use --}}
    {{-- show other nearby avaialable rooms at this time --}}


    @if (!$this->checkInUse())
        <div class="containter-fluid bg-success text-white">
            <div class='container-fluid'>
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col">
                        <h1>Room Available</h1>
                    </div>
                    <div class='col'></div>
                    <div class="col">
                        <h1>{{ $this->getTime()->format('H:i:s') }}</h1>
                    </div>


                </div>

                <div class="row py-3"></div>
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col">
                        <h3>Room Number: {{ $room->room_number }}</h3>
                    </div>
                </div>
                <div class="row py-2"></div>


                <div class="row justify-content-center align-items-center g-2 rounded bg-light text-black border-black">
                    <h3>Facilities:
                        @foreach ($room->facilities as $facility)
                            <a class="btn btn-warning btn-lg" href="">{{ $facility->name }}</a>
                        @endforeach
                    </h3>
                    <h3>Capacity: {{ $room->capacity }}</h3>
                </div>
                <div class="row py-3"></div>
                <div class="row bg-secondary py-3 border border-secondary">
                    <h1>Book Now</h1>
                </div>
                <div class="row bg-light py-5 border border-light">
                    <div class='col'><button class="btn btn-light btn-lg">15 mins</button></div>
                    <div class='col'><button class="btn btn-light btn-lg">30 mins</button></div>
                    <div class='col'><button class="btn btn-light btn-lg">45 mins</button></div>
                    <div class='col'><button class="btn btn-light btn-lg">1 hour</button></div>
                    <div class='col'><button class="btn btn-light btn-lg">1.5 hours</button></div>
                    <div class='col'><button class="btn btn-light btn-lg">2 hours</button></div>
                </div>
                <div class="row bg-secondary py-3 border border-secondary"></div>
                <div class="row py-3"></div>

                <div class="row py-3">
                    <h3>Next Booked Meeting is at
                        @if ($this->getNextBooking())
                            {{ Carbon\Carbon::parse($this->getNextBooking()->time_of_booking)->format('d-m-Y H:i') }}
                        @endif
                    </h3>
                </div>
                <div class="row justify-content-center align-items-center g-2 py-5">
                    <div class="col">
                        <button type="button" class="btn btn-danger btn-lg">Report Issue</button>
                    </div>
                    <div class="col"></div>
                    <div class="col"></div>
                </div>

                <div class="row justify-content-center align-items-center g-2 py-5"></div>

            </div>
        @else
            <div class="containter-fluid bg-danger text-white">
                <div class='container-fluid'>
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col">
                            <h1>Room Booked</h1>
                        </div>
                        <div class='col'></div>
                        <div class="col">
                            <h1>{{ $this->getTime()->format('H:i:s') }}</h1>
                        </div>


                    </div>

                    <div class="row py-3"></div>
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col">
                            <h3>Room Number: {{ $room->room_number }}</h3>
                        </div>
                    </div>
                    <div class="row py-2"></div>


                    <div
                        class="row justify-content-center align-items-center g-2 rounded bg-light text-black border-black">
                        <h3>Facilities:
                            @foreach ($room->facilities as $facility)
                                <a class="btn btn-warning btn-lg" href="">{{ $facility->name }}</a>
                            @endforeach
                        </h3>
                        <h3>Capacity: {{ $room->capacity }}</h3>
                    </div>
                    <div class="row py-3"></div>

                    <div class="row bg-secondary py-3 border border-secondary">
                        <div class="col">
                            @if (!$this->isCheckedIn())
                                <button type="button" class="btn btn-primary btn-lg">Check-in</button>
                            @else
                                <button type="button" class="btn btn-primary btn-lg">End Meeting</button>
                            @endif

                        </div>
                        <div class="col"><button type="button" class="btn btn-primary btn-lg">Book Another Room
                                Now</button></div>
                    </div>
                    <div class="row py-3 "></div>

                    <div class="row py-3">
                        @if ($this->getNextBooking())
                            <h3>Next Booked Meeting is at

                                {{ Carbon\Carbon::parse($this->getNextBooking()->time_of_booking)->format('d-m-Y H:i') }}
                        @endif

                        </h3>
                        <p></p>
                        <h3>
                            @if ($this->getNextFree())
                                Room is next free at
                                {{ Carbon\Carbon::parse($this->getNextFree())->format('d-m-Y H:i') }}
                            @endif

                        </h3>
                    </div>
                    <div class="row justify-content-center align-items-center g-2 py-5">
                        <div class="col">
                            <button type="button" class="btn btn-outline-light btn-lg">Report Issue</button>
                        </div>
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>

                    <div class="row justify-content-center align-items-center g-2 py-5"></div>

                </div>



    @endif
</div>
</div>
