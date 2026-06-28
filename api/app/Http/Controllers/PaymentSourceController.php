<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\ParticipantLog;
use App\Models\PaymentSource;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentSourceController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentSource $paymentSource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentSource $paymentSource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentSource $paymentSource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentSource $paymentSource)
    {
        //
    }

    public function paymentSources(Request $request, PaymentSource $paymentSource, Registration $registration) {

        try {
            $transactionNumber = $request->transactionNumber;

            if (!$transactionNumber) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No transaction number provided.'
                ]);
            }

            $getRegistration = $registration
                ->where('transaction_number', $transactionNumber)
                ->first();

            if (!$getRegistration) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No registration found.'
                ]);
            }

            $paymentSources = $paymentSource->where('event_id', $getRegistration->event_id)->orderBy('id');

            return response()->json([
                'data' => $paymentSources->get(),
                'message' => '',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function paymentSuccessRedirect(Request $request, Registration $registration, Collection $collection, ParticipantLog $participantLog) {

        DB::beginTransaction();
        try {
            $requestReferenceNumber = $request->requestReferenceNumber;
            if (!$requestReferenceNumber) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No reference number provided.'
                ]);
            }

            $getRegistration = $registration
                ->where('transaction_number', $requestReferenceNumber)
                ->first();
            
            if (!$getRegistration) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No registration found.'
                ]);
            }

            if ($getRegistration->event_status == 'pending') {
                    
                $collection->create([
                    'event_id' => $getRegistration->event_id,
                    'collected_amount' => $getRegistration->event_category_total,
                    'payment_status' => 'paid',
                    'fee_type' => 'collection',
                    'payment_remarks' => 'Payment for transaction number: ' . $getRegistration->transaction_number,
                    'collected_amout' => $getRegistration->event_category_total,
                ]);

                $participantLog->create([
                    'event_id' => $getRegistration->event_id,
                    'registration_id' => $getRegistration->id,
                    'transaction_number' => $getRegistration->transaction_number,
                    'logs' => 'Payment successful for transaction number: ' . $getRegistration->transaction_number,
                    'status' => 'paid',
                ]);
            }


            $getRegistration->event_status = 'fullfil';
            $getRegistration->save();

            DB::commit();


            return redirect(config('app.frontend_url') . '/thank-you?transaction_number=' . $requestReferenceNumber);
            // return '';
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function paymentSuccess(Request $request, Registration $registration) {

        DB::beginTransaction();
        try {
            
            $requestReferenceNumber = $request->requestReferenceNumber;
            if (!$requestReferenceNumber) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No reference number provided.'
                ]);
            }

            $getRegistration = $registration
                ->where('maya_checkout_id', $requestReferenceNumber)
                ->first();

            if (!$getRegistration) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No registration found.'
                ]);
            }

            $getRegistration->event_status = 'fullfil';
            $getRegistration->save();
            
            DB::commit();


            // return redirect(config('app.frontend_url') . '/thank-you?transaction_number=' . $transactionNumber);
            return '';
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
