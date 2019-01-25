<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Retailer;
use App\Http\Controllers\Controller;

class RetailerController extends Controller{
    /**
     * Create user
     *
     * @param  [string] user_id
     * @param  [string] password
     */

    public function retailer(Request $request)
    {
        // Check user existed
        if ($u = Retailer::where('contract_id', '=', $request->contract_id)->first())
        {
            return response()->json([
                'type' => 'RETAILER',
                'status' => 'ERROR',
                'message' => 'Contract existed!'
            ], 400);
        } 

        $request->validate([
            'contract_id' => 'required|string',
            'sales' => 'required|string',
            'user_id' => 'required|string',
        ]);

        $retailer = new Retailer([
            'contract_id' => $request->contract_id,
            'sales' => $request->sales,
            'user_id' => $request->user_id
        ]);

        $user->save();

        return response()->json([
            'type' => 'RETAILER',
            'status' => 'SUCCESS',
            'message' => 'Successfully created retailer!'
        ], 201);
    }

   
}