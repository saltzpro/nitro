<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\RegistrationResource;
use App\Mail\RegistrationCompleteMail;
use App\Models\Collection;
use App\Models\ParticipantLog;
use App\Models\ParticipantTshirt;
use App\Models\PaymentProof;
use App\Models\Registration;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        DB::beginTransaction();

        try {

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

            $totalAmount = 0;
            foreach ($request->orderSummary as $order) {
                $orders[] = Transaction::create([
                    'registration_id' => $newRegister->id,
                    'order' => $order['order'],
                    'amount' => $order['amount']
                ]);
            }

            $participantLogs->create([
                'event_id' => $newRegister->event_id,
                'registration_id' => $newRegister->id,
                'transaction_number' => $transactionNumber,
                'logs' => 'New registration added transaction #' . $transactionNumber,
                'status' => 'pending'
            ]);

            foreach ($request->shirts as $shirt) {
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

            $data = [
                'transaction_number' => $transactionNumber,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'event_id' => $request->event_id,
                'orders' => $orders,
                'subject' => 'Registration for payment - Transaction #' . $transactionNumber
            ];

            Mail::to($request->email)
                ->send(new RegistrationCompleteMail($data));

            DB::commit();

            return response()->json([
                'data' => $newRegister,
                'status' => 'success',
                'message' => 'Participant data successfully registered.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
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

    public function transactionSendProof(Request $request, Registration $registration, ParticipantLog $participantLogs, PaymentProof $paymentProof) {
        DB::beginTransaction();
        try {

            $alreadySendProof = $registration->where('transaction_number', $request->transaction_number)
                                            ->where('event_status', 'for review')
                                            ->first();  

            if ($alreadySendProof) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment proof already sent for this transaction number and is currently under review.'
                ]);
            }   

            $registration->where('transaction_number', $request->transaction_number)
                    ->update([
                        'event_status' => 'for review',
                    ]);



            if ($request->hasFile('proof')) {
                $proofPath = Storage::disk('nitro_images')->putFile('payment_proofs', $request->file('proof'));
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment proof file is required.'
                ]);
            }

            $updatedRegistration = $registration->where('transaction_number', $request->transaction_number)->first();

            $paymentProof->create([
                'registration_id' => $updatedRegistration->id,
                'name' => $request->name,
                'phone_number' => $request->phone,
                'payment_from' => $request->paymentFrom,
                'reference_number' => $request->reference,
                'amount' => $request->amount,
                'proof_path' => $proofPath
            ]);

            $getSelectedRegistration = $registration->where('transaction_number', $request->transaction_number)->first();

            $participantLogs->create([
                'event_id' => $getSelectedRegistration->event_id,
                'registration_id' => $getSelectedRegistration->id,
                'transaction_number' => $request->transaction_number,
                'logs' => 'Payment proof sent for transaction #' . $request->transaction_number,
                'status' => 'for review'
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Payment proof successfully sent.',
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
