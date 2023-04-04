<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use App\Models\Building;
use Carbon\Carbon;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
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

    public $nextBooking;

    //public $in_use;

    // public $checked_in;

    public $current_booking;

    public $available_rooms_button_pressed;

    public function boot()
    {
        //$this->in_use = false;

        $this->time = $this->time = Carbon::now();
        $this->available_rooms_button_pressed = false;
    }

    public function reportIssue($issue)
    {

        dd($issue);
        Mail::raw("Tablet from room " . $this->room->room_number . " on level " . $this->room->level . "in building " . $this->room->building->name . " on " . $this->room->building->campus . " Campus is have an issue with " . $issue, function (Message $message) {
            $message->to("supporst@university.com");
        });

        Mail::raw("Tablet from room " . $this->room->room_number . " on level " . $this->room->level . "in building " . $this->room->building->name . " on " . $this->room->building->campus . " Campus is have an issue with " . $issue, function ($message) {
            $message->from('tabletIssue@university.com', 'Laravel');

            $message->to('support@univeristy.com');
        });
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
        return $this->current_booking->checked_in;
    }
    public function checkIn()
    {

        $this->current_booking->checked_in = true;
        $this->current_booking->save();
        $this->refreshBooking();
        $this->emit('refreshComponent');

        //$this->checked_in = true; //when meeting ends this should then be set to false
    }

    public function getNextBooking()
    {
        if (count($this->bookings) > 0) {
            $this->nextBooking =
                $this->bookings
                    ->toQuery()
                    ->where('room_id', '=', $this->room->id)
                    ->where('time_of_booking', '>', $this->time->format('Y-m-d H:i:s'))
                    ->orderBy('time_of_booking', 'asc')
                    ->first();
            return $this->nextBooking;
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
        $this->refreshBooking();
        $this->emit('refreshComponent');


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
        if ($this->nextBooking != null) {
            if ($this->nextBooking->time_of_booking->lte(Carbon::now()->addMinutes($duration))) {
                return redirect()->route('tabletView', ['room' => $this->room])->with('error', "Next Meeting too soon to book allowed");
            }
        }

        $b = new Booking();
        $b->time_of_booking = $time_for_booking_original;
        $b->duration = $duration;
        $b->room_id = $this->room->id;
        $b->user_id = null;
        $b->checked_in = false;
        $b->checked_in = true;
        $b->save();

        $this->refreshBooking();
        $this->emit('refreshComponent');

        //put some validation to make sure there is no double bookings here.
    }

    public function endMeeting()
    {
        $newDuration = $this->getTime()->diffInMinutes(Carbon::parse($this->current_booking->time_of_booking));
        $this->current_booking->duration = $newDuration;
        $this->current_booking->checked_in = false;
        $this->current_booking->save();
        $this->available_rooms_button_pressed = false;
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

        foreach ($this->room->building->rooms as $room) {
            if (
                $room->floor == $this->room->floor
                and $room->id != $this->room->id and !$this->checkInUse($room)
            ) {
                array_push($availableRooms, $room);
            }
        }

        if (sizeOf($availableRooms) < 10) {
            foreach ($this->room->building->rooms as $room) {
                if ($room->id != $this->room->id and !$this->checkInUse($room)) {
                    array_push($availableRooms, $room);
                }
            }
        }

        $availableRooms = array_unique($availableRooms);
        $closestBuildings = $this->getClosestBuildings();

        if (sizeOf($availableRooms) < 10) {
            foreach ($this->rooms as $room) {
                if ($room->building_id == $closestBuildings[0] and !$this->checkInUse($room)) {
                    array_push($availableRooms, $room);
                }
            }
            foreach ($this->rooms as $room) {
                if ($room->building_id == $closestBuildings[1] and !$this->checkInUse($room)) {
                    array_push($availableRooms, $room);
                }
            }

            $availableRooms = array_unique($availableRooms);


        }
        return collect($availableRooms)->sortBy('room_number')->sortBy('floor')->sortBy('building_id');
    }

    /**
     * Function that finds other available rooms with at least the same capacity and facilities.
     */
    public function findAvailableRoomWithFacilities()
    {
        $this->refreshBooking(); //this method just gets an updated collection of bookings from the database.
        $availableRooms = [];

        //Checks current floor for availability
        foreach ($this->room->building->rooms as $room) {
            if (
                $room->floor == $this->room->floor
                and $room->id != $this->room->id and !$this->checkInUse($room)
                and $room->capacity >= $this->room->capacity and $this->checkFacilities($this->room, $room)
            ) {
                array_push($availableRooms, $room);
            }
        }

        //Checks the rest of the building for availability
        if (sizeOf($availableRooms) < 10) {
            foreach ($this->room->building->rooms as $room) {
                if (
                    $room->id != $this->room->id
                    and !$this->checkInUse($room)
                    and $room->capacity >= $this->room->capacity
                    and $this->checkFacilities($this->room, $room)
                ) {
                    array_push($availableRooms, $room);
                }
            }
        }

        $availableRooms = array_unique($availableRooms);

        //finds the 2 closest buildings
        $closestBuildings = $this->getClosestBuildings();


        //checks the 2 closest buildings for rooms
        if (sizeOf($availableRooms) < 10) {
            $building1 = Building::findOrFail($closestBuildings[0]);
            foreach ($building1->rooms as $room) {
                if (
                    !$this->checkInUse($room)
                    and $room->capacity >= $this->room->capacity
                    and $this->checkFacilities($this->room, $room)
                ) {
                    array_push($availableRooms, $room);
                }
            }
            $building2 = Building::findOrFail($closestBuildings[1]);
            foreach ($building2->rooms as $room) {
                if (
                    !$this->checkInUse($room)
                    and $room->capacity >= $this->room->capacity
                    and $this->checkFacilities($this->room, $room)
                ) {
                    array_push($availableRooms, $room);
                }
            }
        }

        $availableRooms = array_unique($availableRooms);
        return $availableRooms;
    }

    public function checkFacilities($thisRoom, $room)
    {
        $thisRoomFacilities = array();
        $roomFacilities = array();
        if (count($thisRoom->facilities) == count($room->facilities) and count($this->room->facilities->diff($room->facilities)) == 0) {
            return true;
        } else {
            foreach ($thisRoom->facilities as $facility) {
                array_push($thisRoomFacilities, $facility->name);
            }

            foreach ($room->facilities as $facility) {
                array_push($roomFacilities, $facility->name);
            }

            foreach ($thisRoomFacilities as $facility) {
                if (!in_array($facility, $roomFacilities)) {
                    return false;
                }
            }

            return true;
        }

    }

    public function distanceBetweenBuildings($b1, $b2)
    {
        //convert GPS points to Radians
        $b1Long = deg2rad($b1->gps_longitude);
        $b1Lat = deg2rad($b1->gps_latitude);
        $b2Long = deg2rad($b2->gps_longitude);
        $b2Lat = deg2rad($b2->gps_latitude);

        $longitudeDiff = $b2Long - $b1Long;
        $latitudeDiff = $b2Lat - $b1Lat;

        $a = pow(sin($latitudeDiff / 2), 2) + cos($b1Lat) * cos($b2Lat) * pow(sin($longitudeDiff / 2), 2);

        $radiusOfEarth = 6378160; //in m

        // $a = max($b1->gps_latitude, $b2->gps_longitude) - min($b1->gps_latitude, $b2->gps_longitude);
        // $b = max($b1->gps_longitude, $b2->gps_longitude) - max($b1->gps_longitude, $b2->gps_longitude);
        // $c = sqrt(pow($a, 2) + pow($b, 2));
        return 2 * asin(sqrt($a)) * $radiusOfEarth;
    }
    private function getClosestBuildings()
    {
        $buildings = [];
        $current_building = $this->room->building;
        //loop through all buildings
        foreach ($this->buildings as $building) {
            //adds to the array the distance the return from $this->distanceBetweenBuildings($current_building, $building) with the building id as the key
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