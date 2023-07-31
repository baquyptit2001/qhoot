<?php

namespace App\Http\Controllers\Client;

use App\Events\JoinRoomEvent;
use App\Events\LeaveRoomEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\Quiz\RoomResource;
use App\Http\Resources\Quiz\RoomUserResource;
use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function show(Room $room, Request $request)
    {
        return response()->json([
            "message" => "Room retrieved successfully",
            "room" => RoomResource::make($room)
        ], 200);
    }

    public function join(Room $room, Request $request) {
        $roomUser = new RoomUser();
        $roomUser->user_id = Str::uuid();
        $roomUser->room_id = $room->id;
        $roomUser->name = $request->get("name");
        $roomUser->save();
        event(new JoinRoomEvent($roomUser));
        return response()->json([
            "message" => "You have joined this room successfully",
            "roomUser" => RoomUserResource::make($roomUser)
        ], 200);
    }

    public function store(Request $request)
    {
        $room = new Room();
        $room->user_id = $request->user()->id;
        $room->name = $request->get("name");
        $room->description = $request->get("description");
        $room->topic_id = $request->get("topic_id");
        if ($request->get('hasPassword')) {
            $room->password = $request->get("password");
        }
        $room->save();
        return response()->json([
            "message" => "Room created successfully",
            "room" => RoomResource::make($room)
        ], 201);
    }

    public function leave(Request $request, Room $room) {
        $roomUser = RoomUser::where("user_id", $request->user_id)->where("room_id", $room->id)->first();
        $roomUser->delete();
        event(new LeaveRoomEvent($request->user_id));
        return response()->json([
            "message" => "You have left this room successfully"
        ], 200);
    }
}
