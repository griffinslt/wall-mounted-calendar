<div>
    <div wire:poll.30000ms>
        @php
            $this->refreshBooking();
        @endphp
        @if (!$this->checkInUse($this->room))

            <div class="containter-fluid bg-success text-white">
                <div class='container-fluid'>
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-10">
                            <h1>Room Available</h1>
                        </div>

                        <div class="col">
                            <h1>{{ $this->getTime()->format('H:i') }}</h1>
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
                        class="row justify-content-center align-items-center g-2 rounded bg-light text-black border-black mx-1">
                        <h3>Facilities:
                            @foreach ($room->facilities as $facility)
                                <div class="badge bg-warning text-wrap text-black fw-normal">{{ $facility->name }}</div>
                            @endforeach
                        </h3>
                        <h3>Capacity: {{ $room->capacity }}</h3>
                    </div>
                    <div class="row py-3"></div>
                    <div class="row bg-secondary py-3 border border-secondary rounded mx-1">
                        <h1>Book Now</h1>

                        <div class="row bg-light py-5 border border-light rounded m-1 px-5" style="height: 100%;">
                            <div class='col'><button wire:click="bookMeeting({{ 15 }})"
                                    class="btn btn-light btn-lg">15 mins</button></div>
                            <div class='col'><button wire:click="bookMeeting({{ 30 }})"
                                    class="btn btn-light btn-lg">30 mins</button></div>
                            <div class='col'><button
                                    wire:click="bookMeeting({{ 45 }})"class="btn btn-light btn-lg">45
                                    mins</button></div>
                            <div class='col'><button
                                    wire:click="bookMeeting({{ 60 }})"class="btn btn-light btn-lg">1
                                    hour</button></div>
                            <div class='col'><button wire:click="bookMeeting({{ 90 }})"
                                    class="btn btn-light btn-lg">1.5 hours</button></div>
                            <div class='col'><button wire:click="bookMeeting({{ 120 }})"
                                    class="btn btn-light btn-lg">2 hours</button></div>
                        </div>
                        <div class="row bg-secondary py-3 border border-secondary rounded mx-1"></div>
                    </div>
                    <div class="row py-3"></div>

                    <div class="row py-3">

                        @if ($this->getNextBooking())
                            <h3>Next Booked Meeting is at
                                {{ Carbon\Carbon::parse($this->getNextBooking()->time_of_booking)->format('d-m-Y H:i') }}
                            </h3>
                        @endif

                    </div>
                    <div class="row justify-content-center align-items-center g-2 py-5">
                        <div class="col">
                            <button data-bs-target="#reportIssueModal" data-bs-toggle="modal" type="button"
                                class="btn btn-danger btn-lg">Report Issue</button>
                        </div>
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>

                    <div class="row justify-content-center align-items-center g-2 py-5"></div>

                </div>
            @else
                @if ($this->isCheckedIn())
                    @php
                        $bgColour = 'danger';
                        $textColour = 'light';
                    @endphp
                @else
                    @php
                        $bgColour = 'warning';
                        $textColour = 'black';
                    @endphp
                @endif
                <div class="containter-fluid bg-{{ $bgColour }} text-{{ $textColour }}">
                    <div class='container-fluid'>
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-10">
                                <h1>Current Booking Ends At
                                    {{ Carbon\Carbon::parse($this->current_booking->time_of_booking)->addMinutes($this->current_booking->duration)->format('H:i') }}
                                </h1>
                            </div>
                            {{-- <div class='col'></div> --}}
                            <div class="col">
                                <h1>{{ $this->getTime()->format('H:i') }}</h1>
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
                            class="row justify-content-center align-items-center g-2 rounded bg-light text-black border-black m-1">
                            <h3>Facilities:
                                @foreach ($room->facilities as $facility)
                                    <div class="badge bg-warning text-wrap text-black fw-normal">{{ $facility->name }}
                                    </div>
                                @endforeach
                            </h3>
                            <h3>Capacity: {{ $room->capacity }}</h3>
                        </div>
                        <div class="row py-3"></div>

                        <div class="row bg-secondary py-3 border border-secondary rounded m-1">
                            <div class="col">
                                @if (!$this->isCheckedIn())
                                    <button wire:click="checkIn" type="button"
                                        class="btn btn-primary btn-lg">Check-in</button>
                                @else
                                    <button type="button" wire:click="endMeeting" class="btn btn-primary btn-lg">End
                                        Meeting</button>
                                @endif

                            </div>
                            <div class="col">
                                <button wire:click='pressAvailableRoomsButton' type="button"
                                    class="btn btn-primary btn-lg">
                                    See other available rooms
                                </button>

                            </div>

                        </div>

                        <div class="row py-3 m-1">
                            @if ($this->available_rooms_button_pressed)



                                <div class="container-fluid p-3 border bg-light overflow-auto text-black rounded"
                                    style="max-height: 120px; max-width:500px; min-height: 120px;">
                                    @if (count($this->findAvailableRoom()))
                                        @foreach ($this->findAvailableRoom() as $room)
                                            <h5>{{ $room->building->name }}, Floor {{ $room->floor }}, Room
                                                {{ $room->room_number }}</h5>

                                            <hr>
                                        @endforeach
                                    @else
                                        <h5>No other rooms available at the moment</h5>
                                    @endif
                                </div>
                            @else
                                <div class="container-fluid p-3" style="min-height: 120px;">

                                </div>
                            @endif
                        </div>

                        <div class="row justify-content-center align-items-center g-2">


                            <div class="row py-3 bg-secondary rounded m-1 text-light">
                                <h3>
                                    @if ($this->getNextFree())
                                        Room is next free at <strong>
                                            {{ Carbon\Carbon::parse($this->getNextFree())->format('d-m-Y H:i') }}
                                        </strong>
                                    @endif

                                </h3>

                                <p></p>
                                @if ($this->getNextBooking())
                                    <h3>Next Booked Meeting is at

                                        <strong>{{ Carbon\Carbon::parse($this->getNextBooking()->time_of_booking)->format('d-m-Y H:i') }}</strong>
                                @endif

                                </h3>

                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center g-2 py-3">
                            <div class="col">
                                <button data-bs-target="#reportIssueModal" data-bs-toggle="modal" type="button"
                                    class="btn btn-outline-light btn-lg">Report Issue</button>
                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>

                        <div class="row justify-content-center align-items-center g-2 py-5"></div>

                    </div>







        @endif
    </div>
</div>

</div>



</div>
