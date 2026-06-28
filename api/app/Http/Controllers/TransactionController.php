<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegistrationResource;
use App\Models\Registration;
use App\Models\Transaction;
use App\Services\MayaService;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function transactionOrders(
        Request $request,
        Transaction $transaction,
        Registration $registration
    ) {
        
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

            $transactions = $transaction
                ->where('registration_id', $getRegistration->id)
                ->orderBy('id')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $transactions
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function transactionDetails(Request $request, Registration $registration) {

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

        return new RegistrationResource($getRegistration);
    } catch (\Exception $e) {
        return response()->json([
            'data' => null,
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
        
    }

    public function createPaymentCheckout(MayaService $mayaService) {
        $checkout = $mayaService->createCheckout(
            transactionNumber: '12345566123123',
            amount: 2500,
            customerName: 'Menard'
        );

        return $checkout;
    }   
}
