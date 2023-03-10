<div>
    <form action="{{route('set-cookie')}}">
        @csrf
        <div class="form-floating">
            <select class="form-select" wire:model="selectedBuilding" name="building" id="">
                <option selected>Unselected</option>
                @foreach ($buildings as $building)
                    <option value={{ $building->id }}>{{ $building->name }} </option>
                @endforeach
            </select>
            <label form="floatingSelect">Building</label>
        </div>
        <hr>
        <div class="form-floating">
            <select class="form-select" name="room" id="">
                @if (!$selectedBuilding || $selectedBuilding == 'Unselected')
                    <option selected>Please Select A Building</option>
                @else
                    @foreach (\App\Models\Building::find($this->selectedBuilding)->rooms->sortBy('room_number')->sortBy('floor') as $room)
                        <option value={{ $room->id }}>{{ $room->room_number }} (floor {{ $room->floor }}) </option>
                    @endforeach

                @endif

            </select>
            <label form="floatingSelect">Room</label>
        </div>

        <p></p>
        <button type="submit" class="btn btn-primary btn-lg">Generate Cookie</button>
    </form>
</div>
