<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Component;

class BookingComponent extends Component
{

    protected $listeners = ['refreshComponent' => '$refresh'];
    public $bookings;
    public $rooms;

    public $room;
    public $room_id = 1; //would actually be the room the tablet is connected to

    public $time; //would actually be the current time ($current = Carbon::now();)

    public $in_use;

    public $checked_in;

    public $current_booking;

    

    public function boot()
    {
        $this->in_use = false;
        $this->checked_in = false;
        $this->current_booking = null;
        $this->time = $this->time = Carbon::now();
    }

    public function checkInUse()
    {
        foreach ($this->bookings as $booking) {
            if (
                Carbon::parse($booking->time_of_booking)->lte($this->time) and
                Carbon::parse($booking->time_of_booking)
                    ->addMinutes($booking->duration)
                    ->gte($this->time) and
                ($booking->room_id = $this->room_id)
            ) {
                $this->in_use = true;
                $this->current_booking = $booking;
                break;
            } else {
                $this->in_use = false;
            }
        }

        return $this->in_use;
    }

    public function getTime()
    {
        $this->time = Carbon::now();//Carbon::parse("2023-02-01 10:30:00");/
        return $this->time;
    }

    public function isCheckedIn()
    {
        return $this->checked_in;
    }
    public function checkIn()
    {
        $this->checked_in = true; //when meeting ends this should then be set to false
    }

    public function getNextBooking()
    {
        return $this->bookings
            ->toQuery()
            ->where('room_id', '=', $this->room->id)
            ->where('time_of_booking', '>', $this->time->format('Y-m-d H:i:s'))
            ->orderBy('time_of_booking', 'desc')
            ->first();
    }

    public function getNextFree()
    {
        $endOfCurrentBooking = Carbon::parse($this->current_booking->time_of_booking)->addMinutes($this->current_booking->duration);
        if ($this->getNextBooking()) {
            $nextBooking = Carbon::parse($this->getNextBooking()->time_of_booking);
            return $nextBooking->subtract($endOfCurrentBooking);
        } else {
            return $endOfCurrentBooking;
        }
    }

    public function bookMeeting($duration)
    {
        $b = new Booking;
        $b->time_of_booking = $this->getTime();
        $b->duration = $duration;
        $b->room_id = $this->room->id;
        $b->user_id = null;
        $b->save();
        $this->in_use = true;
        $this->refresh();
        $this->emit('refreshComponent');

        //put some validation to make sure there is no double bookings here.
    }

    public function refreshBooking()
    {

        $this->bookings = Booking::get();

    }

    public function render()
    {
        return view('livewire.booking-component');
    }
}
