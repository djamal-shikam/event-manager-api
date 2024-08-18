<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participant;
use Exception;

class EventController extends Controller
{
    public function list()
    {
        try {
            return Event::all();
            
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function create(Request $request)
    {
        
        try 
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable',
                'location' => 'required',
                'dateEvent' => 'required|date_format:Y-m-d', 
                'maxParticipants' => 'required|integer|min:1',
            ]);

            $event = Event::create($request->all());
            return response()->json([
                "status_code" => 200,
                "status_message" => "Evenement a été bien ajouté avec succes",
                "data" => $event
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        try {
            $event = Event::find($id);
            if ($event) {
                return response()->json($event, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function registerParticipant(Request $request, int $event_id)
    {

        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:participants',
                'phone' => 'required|digit:9'
            ]);
            $event = Event::findOrFail($event_id);

            if($event->participants()->count() >= $event->maxParticipants)
            {
                return response()->json([
                    'message' => 'L\'évenement a atteint le max de participants'
                ]);
            }

            $participant = Participant::firstOrCreate(
                ['name' => $request->name],
                ['email' => $request->email],
                ['phone' => $request->phone]
            );

            $event->participants()->attach($participant);

            return response()->json([
                'message' => 'Participant enregistré avec succes'
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
