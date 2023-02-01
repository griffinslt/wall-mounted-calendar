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
                    ->addMinutes($booking->duration - 1)
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
        $this->time = Carbon::now();
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
        if (count($this->bookings) > 0) {
            return $this->bookings
                ->toQuery()
                ->where('room_id', '=', $this->room->id)
                ->where('time_of_booking', '>', $this->time->format('Y-m-d H:i:s'))
                ->orderBy('time_of_booking', 'asc')
                ->first();
        } else {
            return null;
        }
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
        $time_for_booking_original = $this->getTime()->second(0);
        $time_for_booking = $this->getTime()->second(0);
        $min = intval($time_for_booking->format('i'));

        if ($min > 1 and $min <= 15) {
            $time_for_booking->minute(15);
        } elseif ($min > 15 and $min <= 30) {
            $time_for_booking->minute(30);
        } elseif ($min > 30 and $min <= 45) {
            $time_for_booking->minute(45);
        } elseif ($min > 45 and $min <= 59) {
            $time_for_booking->addHours(1);
            $time_for_booking->minute(0);
        }

        $duration = $duration + $time_for_booking_original->diffInMinutes($time_for_booking);

        $b = new Booking();
        $b->time_of_booking = $time_for_booking_original;
        $b->duration = $duration;
        $b->room_id = $this->room->id;
        $b->user_id = null;
        $b->save();
        $this->in_use = true;
        $this->refreshBooking();
        $this->emit('refreshComponent');

        //put some validation to make sure there is no double bookings here.
    }

    public function endMeeting()
    {
        $newDuration = $this->getTime()->diffInMinutes(Carbon::parse($this->current_booking->time_of_booking));
        $this->current_booking->duration = $newDuration;
        $this->current_booking->save();
        $this->refreshBooking();
        $this->emit('refreshComponent');
    }

    public function refreshBooking()
    {
        $this->bookings = Booking::get();
    }

    public function findAvilableRoom()
    {
        # code...
    }

    public function render()
    {
        return view('livewire.booking-component');
    }
}
