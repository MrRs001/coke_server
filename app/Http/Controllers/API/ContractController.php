<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Import model
use App\Contract;

include "MyConstant.php";

class ContractController extends Controller{


    /**
     * function Check token
     */
    public function checkTokens(Request $request){
        $constant = new MyConstant();
        return $constant->checkTokenRight();
    }
    

    /**
     * 
     * Create contract info
     * @param [string] contract_id
     * @param [string] distribute_code
     * @param [string] sales
     * @param [string] gift_id
     * @param [string] gift_type
     * @param [string] u_name
     * @param [string] u_phone
     * @param [string] u_address
     * 
     */

     public function createContractRetailer(Request $request){

         // Get all variables inside request
         $contract_id = $request->contract_id;
         $distribute_code = $request->distribute_code;
         $sales = $request->sales;
         
         // Check conflict contract id 
         if($check = Contract::where('contract_id' , '=', $contract_id)->first()){
             return response()->json([
                 'type' => 'CONTRACT',
                 'status' => 'ERROR',
                 'message' => 'Contract ID existed!'
             ],400);
         }

         // Validate request
         $request->validate([
             'contract_id' => 'required|string',
             'distribute_code' => 'required|string',
             'sales' => 'required|string',
         ]);

         // Collect data into a object
         $data = [
            'contract_id' => $contract_id,
            'distribute_code' => $distribute_code,
            'sales' => $sales
         ];
         // Create a new object in Contract contain Data get from request
         $contract = new Contract($data);

         // Import object into database with record
         $contract->save();

         // Return values to client
         return response()->json([
             'type' => 'CONTRACT',
             'status' => 'SUCCESS',
             'message' => 'Create contract success!',
             'contract_info' => $data
         ],200);

     }
}