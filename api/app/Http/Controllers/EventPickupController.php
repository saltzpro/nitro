<?php

namespace App\Http\Controllers;

use App\Models\EventPickup;
use Illuminate\Http\Request;

class EventPickupController extends Controller
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
    public function store(Request $request, EventPickup $eventPickup)
    {
        try {
            //code...
            $eventPickups = $eventPickup->create([
                'event_id' => $request->event_id, 
                'pickup_lists' => $request->pickup_lists
            ]);

            return success($eventPickups, 'Event pickup successfully added.');

        } catch (\Exception $e) {
            return error(null, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EventPickup $eventPickup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventPickup $eventPickup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventPickup $eventPickup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventPickup $eventPickup)
    {
        //
        try {
            //code...
            $eventPickup->delete();
            return success([], 'Pickup successfully deleted.');
        } catch (\Exception $e) {
            return error(null, $e->getMessage());
        }
    }
}
