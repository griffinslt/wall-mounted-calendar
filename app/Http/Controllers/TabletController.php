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
    public function show(Request $request)
    {
        $bookings = Booking::all();
        $rooms = Room::all();
        $buildings = Building::all();


        $room_id = $request->cookie("tablet_room");

        if ($room_id) {
            $room = Room::findOrFail($room_id);
            return view('tablet-view', ['bookings' => $bookings, 'rooms' => $rooms, 'room' => $room, 'buildings' => $buildings]);
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
        
        $minutes = 5259492;
        $value = $validatedData['room'];
        $response = new Response(redirect()->route('tablet-view'));
        $response->withCookie(cookie("tablet_room", $value, $minutes, null, null, false, false));
        return $response;
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

    public function report(Request $request, string $issue)
    {
        $room_id = $request->cookie("tablet_room");
        if ($room_id) {
            $room = Room::find($room_id);


            $executed = RateLimiter::attempt(
                $room_id,
                5,
                function () {

                }
            );

            if (!$executed) {
                session()->flash('error', 'Too Many Issues Reported, Try Again In A Minute');
                return redirect()->route('tablet-view');
            }

            Mail::raw("Tablet from room " . $room->room_number . " on level " .
            $room->level . "in building " . $room->building->name . " on " . $room->building->campus .
            " Campus is have an issue with " . $issue, function ($message) {
                $message->from('tablet-issue@university.com', 'Laravel');

                $message->to('support@univeristy.com');
            });

            session()->flash('message', 'Issue Reported');
            return redirect()->route('tablet-view');
        }
        abort(403);
    }

}