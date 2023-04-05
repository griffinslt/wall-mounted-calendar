<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Illuminate\Support\Carbon;
use Livewire\Component;

class FilterRooms extends Component
{

    public $rooms;
    public $buildings;
    public $selectedBuilding;

    public $duration;

    public $day;

    public $month;

    public $time;

    public $year;

    public $hour;

    public $minute;

    public $currentTime;
    public $room;

    public $facilities;

    public $wantedFacilities = array();

    public $capacity;

    

    public function boot()
    {
        $this->currentTime = Carbon::now();
    }



    public function getAvailableRoomsWithBuilding()
    {
        $availableRooms = collect();
        if ($this->time->lte($this->currentTime)) {
            return $availableRooms;
        }

        foreach ($this->buildings->find($this->selectedBuilding)->rooms as $room) {
            if (!$this->checkInUse($room, $this->time) and $this->checkFacilities($room) and $this->checkCapacity($room)) {
                $availableRooms->add($room);
            }
        }

        return $availableRooms->sortBy('room_number')->sortBy('floor');
    }

    public function getAllAvailableRooms()
    {
        $availableRooms = collect();
        if ($this->time->lte($this->currentTime)) {
            return $availableRooms;
        }
        foreach ($this->rooms as $room) {
            if (!$this->checkInUse($room, $this->time) and $this->checkFacilities($room) and $this->checkCapacity($room)) {
                $availableRooms->add($room);
            }
        }

        return $availableRooms->sortBy('room_number')->sortBy('floor')->sortBy('building_id');
    }

    public function checkFacilities($room)
    {
        foreach ($this->wantedFacilities as $facility) {
            if (!$room->facilities->contains($this->facilities->find($facility))) {
                return false;
            }
        }
        return true;
    }
    

    public function checkInUse($room, $time)
    {
        $inUse = false;

        foreach ($room->bookings as $booking) {
            $inUse = false;
            if (
                $booking->time_of_booking->gte($time) and
                $booking->time_of_booking->addMinutes($booking->duration - 1)->gte($time) and
                ($booking->room_id = $room->id)
            ) {
                $inUse = true;
            } else {
                $inUse = false;
            }
        }
        return $inUse;
    }

    public function checkCapacity($room)
    {
        return $room->capacity >= $this->capacity;
    }



    public function setTime()
    {
        $this->time = Carbon::create($this->year, $this->month, $this->day, $this->hour, $this->minute, 0, 'Europe/London');
    }


    public function bookRoom()
    {
        if ($this->room and $this->time and $this->room != "Unselected") {


            $b = new Booking;
            $b->duration = $this->duration;
            $b->time_of_booking = $this->time;
            $b->user_id = auth()->user()->id;
            $b->room_id = $this->room;
            $b->save();

            return redirect()->route('bookings.index')->with('message', 'Booking was Created.');
        }

        session()->flash('error', 'Please selected a room, time and duration to book');

    }

    public function render()
    {
        return view('livewire.filter-rooms');
    }
}