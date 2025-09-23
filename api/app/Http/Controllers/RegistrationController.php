<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Collection;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\ParticipantLog;
use App\Models\ParticipantTshirt;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\RegistrationResource;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Registration $registrations)
    {
        //
        if (isset($request->event_status)) {
            $registrationList = $registrations->where('event_status', 'sssss');
        }
    
        $registrationList = $registrations->orderBy('id');

        return RegistrationResource::collection($registrationList->get());
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
    public function store(RegistrationRequest $request, Registration $registration, ParticipantTshirt $tshirts, ParticipantLog $participantLogs)
    {
        //
        $transactionNumber = Carbon::now()->format('ymdHis');
        $newRegister = $registration->create([
            'transaction_number' => $transactionNumber,
            'event_id' => $request->event_id,
            'event_category_id' => $request->category_id,
            'event_category_total' => $request->total_amount,
            'admin_fees' => $request->admin_fees,
            'event_pickup_id' => $request->pickup_notes,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'organization' => $request->organization,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'emergency_contact_person' => $request->emergency_contact_person,
            'emergency_relationship' => $request->emergency_relationship,
            'emergency_contact_number' => $request->emergency_contact_number
        ]);
        
        $shirts = $request->shirts;

        $participantLogs->create([
            'event_id' => $request->event_id,
            'registration_id' => $newRegister->id,
            'transaction_number' => $transactionNumber,
            'logs' => 'New registration added transaction #' . $transactionNumber,
            'status' => 'pending'
        ]);

        foreach($shirts as $shirt) {
            $tshirts->updateOrCreate(
                [
                    'event_shirt_id' => $shirt['id'],
                    'registration_id' => $newRegister->id,
                ],
                [
                    'size' => $shirt['selected_size']
                ]
            );
        }

        return [
            'data' => $newRegister,
            'status' => 'success',
            'message' => 'Participant data successfully registered you can now proceed to the next process'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Registration $registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registration $registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registration $registration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration)
    {
        //
    }

    public function listOfRegistration(Request $request, Registration $registrations, $status) {
        
        $registrationList = [];

        if ($status && $status != '') {
            $registrationList = $registrations->with(['pickup_notes', 'selected_category', 'selected_event', 'tshirts', 'participant_logs']);

            if ($status != 'all') {
                $registrationList->where('event_status', $status);
            }
          
            $registrationList->where('event_id', $request->event_id)
            ->orderBy('id', 'desc');
        }

        return RegistrationResource::collection($registrationList->paginate(10));
    
    }

    public function dashboardSummary(Request $request, Registration $registrations, Collection $collection) {
        
        $pending = $registrations->where('event_status', 'pending')
                                ->where('event_id', $request->event_id)
                                ->count();

        $confirmed = $registrations->where('event_status', 'confirmed')
                                ->where('event_id', $request->event_id)
                                ->count();

        $fullfil = $registrations->where('event_status', 'fullfil')
                                ->where('event_id', $request->event_id)
                                ->count();

        $collections = $collection->where('fee_type', 'collection')
                                ->where('event_id', $request->event_id)
                                ->sum('collected_amount');


        return [
            'pending' => $pending,
            'confirmed' => $confirmed,
            'fullfil' => $fullfil,
            'collected' => $collections,
            'widrawal' => 150000
        ];
    }

    public function recentlyActivities(Request $request, ParticipantLog $participantLogs) {

        $list = $participantLogs->where('event_id', $request->event_id)
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);

        return $list;
    }
}
