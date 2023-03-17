<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class TabletController extends Controller
{
    public function show(Room $room, Request $request)
    {
        $bookings = Booking::all();
        $rooms = Room::all();
        $buildings = Building::all();

        
        $value = $request->cookie(strval($room->id));
        // echo $value;
        if ($value) {
            return view('tablet-view', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings]);
        } else if(auth()->check()){
            if (auth()->user()->can('view-all-tablets')) {
                return view('tablet-view', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings]);
            }
        }
        abort(403);
    }

    public function setCookie(Request $request)
    {
        $validatedData = $request->validate([
            'room' => 'required|integer',
            'building' => 'required|integer',
        ]);



        auth()->logout();
        // if (has already been made) {
        //     just assign it that cookie
        // }
        $room = $validatedData['room'];
        $minutes = 5259492;
        $value = mt_rand(111111111111111111, 999999999999999999);
        $response = new Response(redirect()->route('tablet-view', ['room' => intval($room)]));
        $response->withCookie(cookie($validatedData['room'], $value, $minutes, null, null, false, false));
        return $response;
    }

    public function getCookie(Request $request)
    {
        $value = $request->cookie('24');
        dd($value);

    }

    public function setup()
    {
        if (auth()->check()) {
            if (auth()->user()->can('setup-tablet')) {
                $rooms = Room::all();
                $buildings = Building::all();
                return view('tablet-setup', ['rooms' => $rooms, 'buildings' => $buildings]);
            }
        }
        abort(403);



    }

    public function report(Room $room, string $issue)
    {

        $executed = RateLimiter::attempt(
            $room->id,
            $perMinute = 5,
            function () {

            }
        );

        if (!$executed) {
            session()->flash('error', 'Too Many Issues Reported, Try Again In A Minute');
            return redirect()->route('tabletView', ['room' => $room]);
        }

        Mail::raw("Tablet from room " . $room->room_number . " on level " . $room->level . "in building " . $room->building->name . " on " . $room->building->campus . " Campus is have an issue with " . $issue, function ($message) {
            $message->from('tablet-issue@university.com', 'Laravel');

            $message->to('support@univeristy.com');
        });
        //return view('make_booking', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings]);
        session()->flash('message', 'Issue Reported');
        return redirect()->route('tablet-view', ['room' => $room]);
    }

}