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
    public function show(Room $room)
    {
        
        $bookings = Booking::all();
        $rooms = Room::all();
        $buildings = Building::all();
        return view('tablet-view', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings]);
    }

    public function setCookie(Request $request)
    {
        $validatedData = $request->validate([
            'room' => 'required|integer',
            'building' => 'required|integer',
            ]);

        
        $minutes = 1;
        $response = new Response("Hello world");
        $response->withCookie(cookie($validatedData['room'], 'samuel', $minutes));
        return redirect('tablet-view');
    }

    public function getCookie(Request $request)
    {
        $value = $request->cookie(191);
        dd($value);
        
    }

    public function setup()
    {
        $rooms = Room::all();
        $buildings = Building::all();

        return view('tablet-setup', ['rooms' => $rooms, 'buildings' => $buildings]);
    }

    public function report(Room $room, String $issue)
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
        return redirect()->route('tablet-view', ['room' => $room]);
    }
    
}
