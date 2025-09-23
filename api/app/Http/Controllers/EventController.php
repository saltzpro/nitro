<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    /**
     * Display a listing of the event resource.
     */
    public function index(Event $event)
    {
        //
        $limit = isset($request->limit) ? $request->limit : 20;
        $events = $event->orderBy('created_at', 'desc');

        return EventResource::collection($events->paginate($limit));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
        
        return new EventResource($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }

    public function register(Request $request) {
        
    }

    public function eventList(Request $request) {
        return $request->user();
    }

    public function allEvents(Request $request, Event $events) {
        try {
            $limit = isset($request->limit) ? $request->limit : 10;
            $eventsList = $events->where('title', 'like', '%' . $request->search . '%')
                                ->orderBy('created_at', 'desc');

            return EventResource::collection($eventsList->paginate($limit));
        } catch (\Exception  $e) {
            //throw $th;

            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 200);
        }
    }

}
