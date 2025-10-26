<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventShirt;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;

class EventShirtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, EventShirt $eventShirt)
    {
        //
        try {
            //code...
            $eventShirts = $eventShirt->create([
                'event_id' => $request->event_id, 
                'shirt_title' => $request->shirt_title, 
                'shirt_description' => $request->shirt_description, 
                'shirt_sizes' => json_encode($request->shirt_sizes), 
            ]);

            return success($eventShirts, 'Event Ages successfully added.');

        } catch (\Exception $e) {
            return error(null, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EventShirt $eventShirt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventShirt $eventShirt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventShirt $eventShirt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventShirt $eventShirt, Event $events)
    {
        //
        try {
            //code...
            $event = $events->find($eventShirt->event_id);
            $eventShirt->delete();
            return success(new EventResource($event), 'Event shirt successfully deleted.');
        } catch (\Exception $e) {
            return error(null, $e->getMessage());
        }
    }
}
