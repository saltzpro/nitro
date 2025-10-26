<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
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
    public function store(Request $request, EventCategory $eventCategory)
    {
        //
        try {
            //code...
            $eventCategories = $eventCategory->create([
                'event_id' => $request->event_id, 
                'name' => $request->name, 
                'sub_name' => $request->sub_name, 
                'category_image' => $request->category_image, 
                'original_price' => $request->original_price, 
                'current_price' => $request->current_price
            ]);

            return success($eventCategories, 'Event Category successfully added.');

        } catch (\Exception $e) {
            return error(null, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EventCategory $eventCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventCategory $eventCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventCategory $eventCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventCategory $eventCategory)
    {
        //
        try {
            //code...
            $eventCategory->delete();
            return success([], 'Category successfully deleted.');
        } catch (\Exception $e) {
            return error(null, $e->getMessage());
        }
    }
}
