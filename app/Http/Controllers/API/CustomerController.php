<?php

namespace App\Http\Controllers\API;

use App\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller{


    /**
     * Insert new customer
     * 
     * @param [string] customer_code
     */

     public function insertCustomer(Request $request){
        $customer_code = $request->customer_code;

        $customer = new Customer([
            'customer_code' => $customer_code
        ]);

        $customer->save();

        return response()->json([
            'type' => 'ADMIN',
            'status' => 'Insert new customer',
            'customer code' => $customer_code
        ]);
     }

    /** 
     * Customer update info with @param [string] customer_code
     * 
     * @param [string] name
     * @param [string] phone
     * @param [string] address
     * 
    */
     
    public function updateInfo(Request $request){

        // Get parameters
        $customer_code = $request->customer_code;
        $name = $request->name;
        $mobile = $request->mobile;
        $city = $request->city;

        // Check existed customer code
        if(!Customer::where('customer_code', '=', $request->customer_code)->first()){
            return response()->json([
                'type' => 'CUSTOMER',
                'status' => 'ERROR',
                'message' => 'Customer not exist!'
            ]);
        }

        // $request->validate([
        //     'name' => 'required|string',
        //     'mobile' => 'required|string',
        //     'city' => 'required|string'
        // ]);

        $dataUpdate = [
            'name' => $name,
            'mobile' => $mobile,
            'city' => $city
        ];

        // Update customer info into database
        Customer::where('customer_code' , '=' , $customer_code)->limit(1)->update($dataUpdate);
        
        return response()->json([
            'type' => 'CUSTOMER',
            'status' => 'SUCCESS',
            'message' => 'Update customer info success!',
            'customer_info_updated' => $dataUpdate
        ]);

        


    }

}