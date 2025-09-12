<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function getPlans()
    {
        $plans = Plan::with('features')->get();
        return response()->json([
            'status' => 'success',
            'data' => PlanResource::collection($plans),
        ]);
    }

    public function getSubscription($userId)
    {
        $user = User::where('id', $userId)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $subscription = $user->subscription;

        return response()->json([
            'status' => 'success',
            'data' => $subscription,
        ]);
    }
}
