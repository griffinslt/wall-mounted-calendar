<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Carbon\Carbon;
use Livewire\Component;

class BookingComponent extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $bookings;
    public $buildings;
    public $rooms;

    public $room;
    public $room_id = 1; //would actually be the room the tablet is connected to

    public $time; //would actually be the current time ($current = Carbon::now();)

    //public $in_use;

    public $checked_in;

    public $current_booking;

    public $available_rooms_button_pressed;

    public function boot()
    {
        //$this->in_use = false;
        $this->checked_in = false;
        $this->current_booking = null;
        $this->time = $this->time = Carbon::now();
        $this->available_rooms_button_pressed = false;
    }

    public function checkInUse($room)
    {
        $inUse = false;

        foreach ($room->bookings as $booking) {
            $inUse = false;
            if (
                Carbon::parse($booking->time_of_booking)->lte($this->getTime()) and
                Carbon::parse($booking->time_of_booking)
                    ->addMinutes($booking->duration - 1)
                    ->gte($this->getTime()) and
                ($booking->room_id = $room->id)
            ) {
                //$this->in_use = true;

                $inUse = true;
                if ($room->id == $this->room->id) {
                    $this->current_booking = $booking;
                }

                //break;
            } else {
                //$this->in_use = false;
                $inUse = false;
            }
        }

        //return $this->in_use;
        return $inUse;
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
        //$this->in_use = true;
        $this->refreshBooking();
        $this->emit('refreshComponent');

        //put some validation to make sure there is no double bookings here.
    }

    public function endMeeting()
    {
        $newDuration = $this->getTime()->diffInMinutes(Carbon::parse($this->current_booking->time_of_booking));
        $this->current_booking->duration = $newDuration;
        $this->current_booking->save();
        $this->checked_in = false;
        $this->refreshBooking();
        $this->emit('refreshComponent');
    }

    public function refreshBooking()
    {
        $this->bookings = Booking::get();
    }

    public function findAvailableRoom()
    {
        $this->refreshBooking();

        $availableRooms = [];
        foreach ($this->rooms as $room) {
            if ($room->building_id == $this->room->building_id and $room->floor == $this->room->floor 
            and $room->id != $this->room->id and !$this->checkInUse($room) 
            and $room->capacity >= $this->room->capacity) {
                array_push($availableRooms, $room);
            }
        }

        if (sizeOf($availableRooms) < 100) {
            foreach ($this->rooms as $room) {
                if ($room->building_id == $this->room->building_id and $room->id != $this->room->id and !$this->checkInUse($room) and $room->capacity >= $this->room->capacity) {
                    array_push($availableRooms, $room);
                }
            }
        }

        $availableRooms = array_unique($availableRooms);
        $closestBuildings = $this->getClosestBuildings();

        if (sizeOf($availableRooms) < 100) {
            foreach ($this->rooms as $room) {
                if ($room->building_id == $closestBuildings[0] and !$this->checkInUse($room) and $room->capacity >= $this->room->capacity) {
                    array_push($availableRooms, $room);
                }
            }
            foreach ($this->rooms as $room) {
                if ($room->building_id == $closestBuildings[1] and !$this->checkInUse($room) and $room->capacity >= $this->room->capacity) {
                    array_push($availableRooms, $room);
                }
            }
        }

        //dd($availableRooms);
        return $availableRooms;
    }

    public function distanceBetweenBuildings($b1, $b2)
    {
        $a = max($b1->gps_latitude, $b2->gps_longitude) - min($b1->gps_latitude, $b2->gps_longitude);
        $b = max($b1->gps_longitude, $b2->gps_longitude) - max($b1->gps_longitude, $b2->gps_longitude);
        $c = sqrt(pow($a, 2) + pow($b, 2));
        return $c;
    }
    private function getClosestBuildings()
    {
        $buildings = [];
        $current_building = $this->room->building;
        foreach ($this->buildings as $building) {
            if ($building != $current_building and $building->campus == $current_building->campus) {
                $buildings = $buildings + [floatval($building->id) => $this->distanceBetweenBuildings($current_building, $building)];
            }
        }
        $originalBuildings = $buildings;
        sort($buildings, SORT_NUMERIC);
        $closest = array_shift($buildings);
        $second_closest = array_shift($buildings);
        $twoClosest = [array_search($closest, $originalBuildings), array_search($second_closest, $originalBuildings)];
        return $twoClosest;
    }

    public function pressAvailableRoomsButton()
    {
        $this->available_rooms_button_pressed = !$this->available_rooms_button_pressed;
        return $this->available_rooms_button_pressed;
    }

    public function render()
    {
        return view('livewire.booking-component');
    }
}
