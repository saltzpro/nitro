<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\ParticipantLog;

class CollectionController extends Controller
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
    public function store(Request $request, Collection $collection, Registration $registration, ParticipantLog $participantLog)
    {
        //
        $registrant = $registration->find($request->registration_id);

        if(!$registrant) {
            return [
                'data' => [],
                'status' => 'error',
                'message' => 'Registrant not found!'
            ];
        }

        $registrant->event_status = $request->event_status;
        $registrant->save();

        $collection->create([
            'event_id' => $registrant->event_id,
            'collected_amount' => $registrant->event_category_total,
            'fee_type' => 'collection',
            'payment_status' => 'paid'
        ]);

        $collection->create([
            'event_id' => $registrant->event_id,
            'collected_amount' => $registrant->admin_fees,
            'fee_type' => 'adminfees',
            'payment_status' => 'paid'
        ]);

        $participantLog->create([
            'event_id' => $registrant->event_id,
            'registration_id' => $request->registration_id,
            'transaction_number' => $registrant->transaction_number,
            'logs' => 'Registration confirmed'
        ]);
        
        return [
            'data' => [],
            'status' => 'success',
            'message' => 'Registration successfully confirm. moving registration to confirmed status'
        ];

    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        //
    }
}
