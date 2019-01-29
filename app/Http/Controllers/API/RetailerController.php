<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Retailer;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

include 'MyConstant.php';

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
            'user_id' => 'required|string'
        ]);

        $retailer = new Retailer([
            'contract_id' => $request->contract_id,
            'sales' => $request->sales,
            'user_id' => $request->user_id
        ]);

        $retailer->save();

        return response()->json([
            'type' => 'RETAILER',
            'status' => 'SUCCESS',
            'message' => 'Successfully created retailer!'
        ], 201);
    }


    public function upload_image(Request $request){
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {

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
                'type' => 'RETAILER',
                'status' => 'SUCCESS',
                'image' => $full_path,
                'hash' => $file_hash_content,
                'message' => 'Uploaded image!'
            ],201);

        }else{

            return response()->json([
                'type' => 'RETAILER',
                'status' => 'ERROR',
                'message' => 'Error upload!'
            ],201);

        }
    }


    
   
}