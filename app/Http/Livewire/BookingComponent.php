<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BookingComponent extends Component
{

    public $bookings;
    public $rooms;

    public $room;
    public $room_id = 1; //would actually be the room the tablet is connected to

    public $time = "0000-02-16 14:23:23"; //would actually be the current time ($current = Carbon::now();)



    public function render()
    {
        return view('livewire.booking-component');
    }
}
