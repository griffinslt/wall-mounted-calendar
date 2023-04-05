<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{

    public function index()
    {
        if (!auth()->check()) {
            return view('auth.login');
        }
        if (auth()->user()->can('view-all-rooms')) {
            $rooms = Room::paginate(30);
            return view("admin.rooms.rooms", ['rooms' => $rooms]);
        }
        else {
            abort(403);
        }
    }

    
    public function create()
    {
        $buildings = Building::all();
        return view('admin.rooms.create', ['buildings' => $buildings]);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'capacity' => 'required|integer',
            'room_number' => 'required|integer',
            'floor' => 'required|integer',
            'building' => 'required',
        ]);

        $building = Building::find($validatedData['building']);
        if ($validatedData['floor'] < $building->number_of_floors) {
            $room = new Room;
            $room->capacity = $validatedData['capacity'];
            $room->room_number = $validatedData['room_number'];
            $room->floor = $validatedData['floor'];
            $room->building_id = $validatedData['building'];
            $room->save();

            return redirect()->route('rooms.edit', ['room' => $room->id])->with('message', "Room Created");
        } else {
            return redirect()->route('rooms.index')->with('error', "Room Not Created");
        }
    }

    

    
    public function edit(Room $room)
    {
        $buildings = Building::all();
        $facilities = Facility::all();
        return view('admin.rooms.edit', ['room' => $room, 'buildings' => $buildings, 'facilities' => $facilities]);
    }

    public function addFacilityToRoom(Room $room, Facility $facility)
    {
        try {
            DB::table('facility_room')->insert([
                'facility_id' => $facility->id,
                'room_id' => $room->id,
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->route('rooms.edit', ['room' => $room->id])->with('error', "Facility not added");
        }
        return redirect()->route('rooms.edit', ['room' => $room->id])->with('message', "Facility Added");
    }

    public function removeFacilityFromRoom(Room $room, Facility $facility)
    {
        $facility_room = DB::table('facility_room')->where('facility_id', '=', $facility->id)->where('room_id', '=', $room->id);
        $facility_room->delete();
        return redirect()->route('rooms.edit', ['room' => $room->id])->with('message', "Facility Removed");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $validatedData = $request->validate([
            'capacity' => 'required|integer',
            'room_number' => 'required|integer',
            'floor' => 'required|integer',
            'building' => 'required',
        ]);

        $building = Building::find($validatedData['building']);
        if ($validatedData['floor'] < $building->number_of_floors) {
            $room->capacity = $validatedData['capacity'];
            $room->room_number = $validatedData['room_number'];
            $room->floor = $validatedData['floor'];
            $room->building_id = $validatedData['building'];
            $room->save();


            return redirect()->route('rooms.edit', ['room' => $room->id])->with('message', "Room Updated");
        } else {
            return redirect()->route('rooms.edit', ['room' => $room->id])->with('error', "Invalid Floor Number");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {

        $room->delete();
        return redirect()
            ->route('rooms.index')
            ->with('message', 'Room was Deleted.');
    }
}