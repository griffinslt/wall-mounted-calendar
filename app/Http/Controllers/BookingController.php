<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Building;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class BookingController extends Controller
{

    public function admin()
    {
        return redirect()->route('bookings.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if (auth()->check()) {
            if ($user->can('view-all-bookings')) {
                $bookings = Booking::orderBy('id', 'DESC')->paginate(30);
                return view('admin.bookings.bookings', ['bookings' => $bookings]);
            } else {
                $bookings = Booking::where('user_id', "=", auth()->user()->id)->orderBy('id', 'DESC')->paginate(30);
                return redirect()->route('index-for-logged-in-user');
            }
        } else {
            return view('auth.register');
        }
    }

    public function indexForRoom(Room $room)
    {
        $bookings = $room->bookings;
        return view('admin.bookings.bookings', ['bookings' => $bookings]);
    }
    public function indexForUser(User $user)
    {
        $bookings = Booking::where("user_id", "=", $user->id)->paginate(30);
        return view('admin.bookings.bookings', ['bookings' => $bookings]);
    }

    public function indexUserLoggedIn()
    {
        if (auth()->check()) {
            $user = auth()->user();
            return view('bookings.index', ['user' => $user]);
        } else {
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tabletView(Room $room)
    {
        
        $bookings = Booking::all();
        $rooms = Room::all();
        $buildings = Building::all();
        return view('tablet-view', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings]);
    }

    public function chooseBuilding()
    {

        $buildings = Building::all();
        return view('admin.bookings.choose-building', ['buildings' => $buildings]);
    }

    public function chooseBuildingNormal()
    {
        $buildings = Building::all();
        return view('bookings.choose-building', ['buildings' => $buildings]);
    }

    public function create(Building $building)
    {
        return view('admin.bookings.create', ['building' => $building]);
    }

    public function createNormal(Building $building)
    {
        return view('bookings.create', ['building' => $building]);
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required',
            'duration' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'hour' => 'required',
            'minute' => 'required',
        ]);

        $room = Room::find($validatedData['room_id']);

        $timeCarbon = Carbon::create(
            $validatedData['year'],
            $validatedData['month'],
            $validatedData['day'],
            $validatedData['hour'],
            $validatedData['minute'],
            0,
            'Europe/London'
        );
        $time = $timeCarbon->format('Y-m-d H:i:s');
        if (!$this->checkInUse($room, $timeCarbon) and $timeCarbon->gt(Carbon::now())) {
            $booking = new Booking;
            $booking->duration = $validatedData['duration'];
            $booking->time_of_booking = $time;
            $booking->user_id = auth()->user()->id;
            $booking->room_id = $validatedData['room_id'];
            $booking->save();

            return redirect()->route('bookings.index')->with('message', 'Booking was Created.');
        } else {
            return redirect()->route('bookings.index')->with('error', 'Booking was Not Created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {

        $bookings = Booking::where("room_id", "=", $booking->room->id)->get();
        return view('admin.bookings.edit', ['booking' => $booking, 'bookings' => $bookings]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $validatedData = $request->validate([
            'duration' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'hour' => 'required',
            'minute' => 'required',
        ]);

        $timeCarbon = Carbon::create(
            $validatedData['year'],
            $validatedData['month'],
            $validatedData['day'],
            $validatedData['hour'],
            $validatedData['minute'],
            0,
            'Europe/London'
        );
        $time = $timeCarbon->format('Y-m-d H:i:s');
        if (!$this->checkInUse($booking->room, $timeCarbon) and $timeCarbon->gt(Carbon::now())) {
            $booking->duration = $validatedData['duration'];
            $booking->time_of_booking = $time;
            $booking->save();

            return redirect()->route('bookings.index')->with('message', 'Booking was Updated.');
        } else {
            return redirect()->route('bookings.index')->with('error', 'Booking was Not Updated.');
        }
    }

    public function checkInUse($room, $time)
    {
        $inUse = false;

        foreach ($room->bookings as $booking) {
            $inUse = false;
            if (
                Carbon::parse($booking->time_of_booking)->lte($time) and
                Carbon::parse($booking->time_of_booking)
                ->addMinutes($booking->duration - 1)
                ->gte($time) and
                ($booking->room_id = $room->id)
            ) {
                //$this->in_use = true;
                $inUse = true;
                //break;
            } else {
                //$this->in_use = false;
                $inUse = false;
            }
        }

        //return $this->in_use;
        return $inUse;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()
            ->route('bookings.index')
            ->with('message', 'Booking was Deleted.');
    }

    public function reportIssue(Room $room, String $issue)
    {

        $executed = RateLimiter::attempt(
            $room->id,
            $perMinute = 5,
            function() {
                
            }
        );
         
        if (! $executed) {
            session()->flash('error', 'Too Many Issues Reported, Try Again In A Minute');
          return redirect()->route('tabletView', ['room' => $room]);
        }

        Mail::raw("Tablet from room " . $room->room_number . " on level " . $room->level . "in building " . $room->building->name . " on " .  $room->building->campus . " Campus is have an issue with " . $issue, function ($message) {
            $message->from('tablet-issue@university.com', 'Laravel');

            $message->to('support@univeristy.com');
        });
        //return view('make_booking', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings]);
        session()->flash('message', 'Issue Reported');
        return redirect()->route('tabletView', ['room' => $room]);
    }
}
