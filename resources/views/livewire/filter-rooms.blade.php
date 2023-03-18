<div>
    @if (\Session::has('message'))
        <div class="alert alert-success">
            <ul>
                {!! \Session::get('message') !!}
            </ul>
            @php
                header('Refresh:2');
            @endphp

        </div>
    @endif
    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                {!! \Session::get('error') !!}
            </ul>
            @php
                header('Refresh:2');
            @endphp

        </div>
    @endif



    <div class="form-floating">
        <select wire:model="duration" name="duration" class="form-select" id="floatingSelect"
            aria-label="Floating label select example">
            <option selected>Unselected</option>
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
                <select wire:model="day" name="day" class="form-select" id="floatingSelect"
                    aria-label="Floating label select example">
                    <option selected>Unselected</option>
                    @for ($i = 0; $i < 31; $i++)
                        <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                    @endfor
                </select>
                <label form="floatingSelect">Day</label>
            </div>
        </div>
        <div class="col">
            <div class="form-floating">
                <select wire:model="month" name="month" class="form-select" id="floatingSelect"
                    aria-label="Floating label select example">
                    <option selected>Unselected</option>
                    @for ($i = 0; $i < 12; $i++)
                        <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                    @endfor
                </select>
                <label form="floatingSelect">Month</label>
            </div>
        </div>
        <div class="col">
            <div class="form-floating">

                <select wire:model="year" name="year" class="form-select" id="floatingSelect"
                    aria-label="Floating label select example">
                    <option selected>Unselected</option>
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
                <select wire:model="hour" name="hour" class="form-select" id="floatingSelect"
                    aria-label="Floating label select example">
                    <option selected>Unselected</option>
                    @for ($i = 8; $i < 21; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                <label form="floatingSelect">Hour</label>
            </div>
        </div>
        <div class="col">
            <div class="form-floating">
                <select wire:model="minute" name="minute" class="form-select" id="floatingSelect"
                    aria-label="Floating label select example">
                    <option selected>Unselected</option>
                    @for ($i = 0; $i < 60; $i += 15)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                <label form="floatingSelect">Minute</label>
            </div>
        </div>
    </div>



    <hr>
    <div class="form-floating">
        <select class="form-select" wire:model="selectedBuilding" name="building" id="">
            <option selected>Any</option>
            @foreach ($buildings as $building)
                <option value={{ $building->id }}>{{ $building->name }} </option>
            @endforeach
        </select>
        <label form="floatingSelect">Building</label>
    </div>

    <hr>

    <div class="row justify-content-center align-items-center g-2">
        <div class="col">
            



        </div>
        <div class="col">
            @foreach ($facilities as $facility)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value={{ $facility->id }} id="flexCheckDefault"
                        wire:model="wantedFacilities" name="wantedFacilities[]">
                    <label class="form-check-label" for="flexCheckDefault">
                        {{ $facility->name }}
                    </label>
                </div>
            @endforeach

        </div>
    </div>


    <hr>




    <div class="form-floating">
        <select wire:model="room" class="form-select" name="room" id="">
            <option selected>Unselected</option>
            @if (!($day && $month && $year && $hour && $minute && $duration))
                <option selected>Please Select Another Time and duation</option>
            @else
                @php
                    $this->setTime();
                @endphp
                @if ($selectedBuilding)
                    @php
                        //get rooms from building at that time that are not booked
                    @endphp
                    @foreach ($this->getAvailableRoomsWithBuilding() as $room)
                        <option value={{ $room->id }}>{{ $room->room_number }} (floor {{ $room->floor }})
                        </option>
                    @endforeach
                @else
                    @foreach ($this->getAllAvailableRooms() as $room)
                        <option value={{ $room->id }}>{{ $room->room_number }} (floor {{ $room->floor }} of
                            {{ $room->building->name }})</option>
                    @endforeach
                @endif


            @endif

        </select>
        <label form="floatingSelect">Room</label>



    </div>

    <p></p>
    <button wire:click="bookRoom" class="btn btn-primary btn">Book Room</button>


</div>
