<?php

namespace App\Http\Controllers;

use App\Models\EventAge;
use Illuminate\Http\Request;

class EventAgeController extends Controller
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
    public function store(Request $request, EventAge $eventAge)
    {
        //
        try {
            //code...
            $eventAges = $eventAge->create([
                'event_id' => $request->event_id, 
                'age_from' => $request->age_from, 
                'age_to' => $request->age_to, 
            ]);

            return success($eventAges, 'Event Ages successfully added.');

        } catch (\Exception $e) {
            return error(null, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EventAge $eventAge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventAge $eventAge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventAge $eventAge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventAge $eventAge)
    {
        //
        try {
            //code...
            $eventAge->delete();
            return success([], 'Category successfully deleted.');
        } catch (\Exception $e) {
            return error(null, $e->getMessage());
        }
    }
}
