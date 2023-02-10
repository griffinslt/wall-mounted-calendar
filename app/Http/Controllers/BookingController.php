<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Room $room)
    {
        $bookings = Booking::all();
        $rooms = Room::all();
        $buildings = Building::all();
        return view('tablet-view', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $bookings = Booking::all();
        return view('admin.bookings.bookings', ['bookings' => $bookings]);
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
        if(!$this->checkInUse($booking->room, $timeCarbon) and $timeCarbon->gt(Carbon::now())){
            $booking->duration = $validatedData['duration'];
            $booking->time_of_booking = $time;
            $booking->save();

            return redirect()->route('bookings.show')->with('message', 'Booking was Updated.');

        } else{
            return redirect()->route('bookings.show')->with('error', 'Booking was Not Updated.');
        }





        return $request;
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
            ->route('bookings.show')
            ->with('message', 'Booking was Deleted.');
    }

    public function reportIssue(Room $room, String $issue)
    {

        Mail::raw("Tablet from room " . $room->room_number . " on level " . $room->level . "in building " . $room->building->name . " on " .  $room->building->campus . " Campus is have an issue with " . $issue, function ($message) {
            $message->from('tablet-issue@university.com', 'Laravel');

            $message->to('support@univeristy.com');
        });
        //return view('make_booking', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings]);
        session()->flash('message', 'Issue Reported');
        return redirect()->route('booking.create', ['room' => $room]);
    }
}
