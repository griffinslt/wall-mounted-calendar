<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class BookingComponent extends Component
{

    public $bookings;
    public $rooms;

    public $room;
    public $room_id = 1; //would actually be the room the tablet is connected to

    public $time;  //would actually be the current time ($current = Carbon::now();)

    public $in_use;

    public function boot()
    {
        $this->in_use = false;
        $this->time = Carbon::parse("0000-02-16 14:23:23");
    }


    public function checkInUse()
    {
        foreach ($this->bookings as $booking) {
            if (Carbon::parse($booking->time_of_booking)->lte($this->time) and
            Carbon::parse($booking->time_of_booking)->addMinutes($booking->duration)->gte($this->time)) {
                $this->in_use = true;
            }
        }
    }

    public function updateTime()
    {
        $this->time = Carbon::now();
    }

    public function render()
    {
        return view('livewire.booking-component');
    }
}
