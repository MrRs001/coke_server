<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Import model
use App\Contract;

include "MyConstant.php";

class ReportController extends Controller{
     /**
     * Function return personal have gift
     * @param [string] type 
     */

    public function getReport(Request $request){
        // get type of request
        // VIP -  NORMAL - ALL
        try{
            $type = $request->type;
            $data = [];
            if($type == 'ALL'){
                $data = Contract::all();
            }else{
                $data = Contract::where('gift_type' , '=', $type)->get();
            }
            return response()->json([
                'type' => 'REPORT',
                'status' => 'SUCCESS',
                'message' => 'Type'.' '.$type,
                'data' => $data
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'type' => 'REPORT',
                'status' => 'ERROR',
                'message' => 'ERROR',
                'data' => $e
            ],400);
        }
    }
}