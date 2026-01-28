<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaveCardPayment extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $method = $request->method;
        $user = User::find(auth()->user()->id);

        try {
            $userservice = new UserService($user);
            $userservice->saveDeposit(paymentData: [
                'user_id' => $user->id,
                'payment_mode' => $method,
                'amount' => $request->amount,
                'status' => 'Processed',
            ]);

            $request->session()->forget('deposit_amount');

            return response()->json(['success' => 'Payment Completed, redirecting']);
        } catch (\Throwable) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
