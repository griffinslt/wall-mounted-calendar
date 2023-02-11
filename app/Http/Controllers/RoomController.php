<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::get();
        return view("admin.rooms.rooms", ['rooms' => $rooms]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $buildings = Building::all();
        $facilities = Facility::all();
        return view('admin.rooms.edit', ['room'=>$room, 'buildings'=>$buildings, 'facilities' => $facilities]);
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

        $room->capacity = $validatedData['capacity'];
        $room->room_number = $validatedData['room_number'];
        $room->floor = $validatedData['floor'];
        $room->building_id = $validatedData['building'];
        $room->save();


        return redirect()->route('rooms.edit', ['room' => $room->id])->with('message', "Post Updated");
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
