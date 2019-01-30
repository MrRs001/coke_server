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

    /**
     * function to upload image to contract
     * @param [string] contract_id
     * @param [file] image
     */
    public function updateImage(Request $request){
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');

            //Validate image uploaded
            $file_hash_content = md5_file($image);

            if($modify = Retailer::where('hash_image', '=', $file_hash_content)->first()){
               return response()->json([
                   'type' => 'RETAILER',
                   'status' => 'ERROR',
                   'message' => 'Image existed!'
               ],400); 
            }

            // Set name : contract_id + type of image (png/jpeg.....)
            $name = $request->contract_id.'.'.$image->getClientOriginalExtension();
            
            $constant = new MyConstant();

            $full_path = $constant->DOMAIN.$constant->STORAGE_IMAGE_CONTRACT.'/'.$name;

            $destinationPath = public_path($constant->STORAGE_IMAGE_CONTRACT);
        
            $image->move($destinationPath, $name);

            //Update with conditions
            Retailer::where('contract_id', $request->contract_id)->limit(1)->update([
                'hash_image' => $file_hash_content,
                'image' => $full_path
            ]);

            return response()->json([
                'type' => 'CONTRACT',
                'status' => 'SUCCESS',
                'message' => 'Uploaded image!',
                'image' => $full_path,
                'hash' => $file_hash_content,
            ],200);

        }else{

            return response()->json([
                'type' => 'CONTRACT',
                'status' => 'ERROR',
                'message' => 'Error upload!'
            ],400);

        }
    }

    /**
     * Lucky contract - update info of customer 
     * @param [string] constract_id
     * @param [string] name
     * @param [string] phone
     * @param [string] address
     * 
     */
    public function luckyCustomerUpdate(Request $request){
        $contract_id = $request->contract_id;
        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;

        if($check = Contract::where('contract_id', '=',$contract_id )->first()){
            return response()->json([
                'type' => 'LUCKY',
                'status' => 'ERROR',
                'message' => 'Contract not exist!'
            ], 400);
        }

        $data = [
            'u_name' => $name,
            'u_phone' => $phone,
            'u_address' => $address
        ];

        // Update info 
        Contract::where('contract_id',$contract_id)->limit(1)->update($data);

        return response()->json([
            'type' => 'LUCKY',
            'status' => 'SUCCESS',
            'message' => 'Updated lucky customer info!'
        ]); 
    }

    /**
     * 
     * Upload image to verify when spin out gold necklace
     * @param [file] image address
     * @param [file] image identity 
     * 
     */
    public function uploadImageToVerify(Request $request){
        
    }
   
    
}