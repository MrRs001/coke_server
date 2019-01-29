<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gift;
include 'MyConstant.php';

class GiftController extends Controller{

    /** 
     * Function to get list gift
     * 
    */
    public function getListGift(Request $request){
        return response()->json([
            'type' => 'GIFT',
            'status' => 'SUCCESS',
            'message' => 'Get list gift!',
            'list' => Gift::all()
        ]);
    }

    public function insertNewGift(Request $request){

        $constant = new MyConstant();

        $full_path = "";

        // Handle image 
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            // Set name : contract_id + type of image (png/jpeg.....)
            $nameImage = $request->name.'.'.$image->getClientOriginalExtension();
            // Get path public 
            $destinationPath = public_path($constant->STORAGE_IMAGE_GIFT);
        
            $image->move($destinationPath, $nameImage);

            $full_path = $constant->DOMAIN.$constant->STORAGE_IMAGE_GIFT.'/'.$nameImage;
         
        }

        $gift = new Gift([
            'name' => $request->name,
            'image' => $full_path,
            'price' => $request->price,
            'total_amount' => $request->amount,
            'current_amount' => $request->amount,
            'percent_default' => $request->percent,
            'current_percent' => $request->percent,
            'current_percent' => $request->percent,
            'type' => $request->type
        ]);
        

        $gift->save();

        return response()->json([
            'type' => 'GIFT',
            'status' => 'SUCCESS',
            'message' => 'Insert new gift!',
            'info' => [
                'name' => $request->name,
                'image' => $full_path,
                'price' => $request->price,
                'total_amount' => $request->amount,
                'current_amount' => $request->amount,
                'percent_default' => $request->percent,
                'current_percent' => $request->percent,
                'type' => $request->type
            ]
        ]);
    }

    public function getDataArrayToRandom(){
        $data = [];
        // Get amount record of Gift table 
        $count = Gift::count();
        for($i = 0; $i < $count; $i++){
            // Get percent of gift with index
            $index = $i + 1;

            $percentgift = Gift::where('id', '=' ,$index)->value('current_percent');

            $data[$index] = $percentgift;
        }
        // Return array contain index and percent of gift
        return $data;
    }
   

    public function requestgift(Request $request){
        // Check token
        $con = new MyConstant();
        if($con->tokenVail($request)){
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Token expired !'
            ],400);
        }

     
        //Value of contract 
        //Percent's gift
        //Gift amount
        // Handle with 3
        $value = $request->level;
        $results = [];

        $data = $this->getDataArrayToRandom();

        // $this->testRandom($data, $results);
        // Compare between current amount and total amount
        $randomNumber = $this->random($data, $results);
        
        // Cached id to except when minus percent gifts
        $cacheID  = $randomNumber; 

        // ** Handle Percent **
        // Get current percent 
        $current_percent = Gift::where('id' ,'=', $randomNumber)->value('current_percent');
        // Calculator percent
        $m_total_amount = Gift::where('id' ,'=', $randomNumber)->value('total_amount');
        $m_current_amount = Gift::where('id' ,'=', $randomNumber)->value('current_amount');
        $result_minus = $m_total_amount - $m_current_amount ;

        $_20percent = ($m_total_amount/100) * 20;
        $_40percent = ($m_total_amount/100) * 40;
        $_60percent = ($m_total_amount/100) * 60;
        $_80percent = ($m_total_amount/100) * 80;

        $upto = 10;

        $percentWillBeMinus = 0;

        $giftsHaveBeenSelectedArray = [];
        // CAN delete variable ////// 
        $itemOfGiftSelected = 0; 
        $itemHasBeenEdited = [];

        if($result_minus == $_20percent || $result_minus == $_40percent || $result_minus == $_60percent || $result_minus == $_80percent){
            // Check if is bad
            if(Gift::where('id' ,'=', $randomNumber)->value('name') == 'BAD'){
                // BAD is exception => down 40% then upto
                if($result_minus == $_40percent || $result_minus == $_60percent || $result_minus == $_80percent){
                    $current_percent += 10;
                }

            }else{
                $current_percent += 10;
                
            }

            // Handling percent
            $highestPercent = 0;
            $lowestPercent = 0;
            // / ********* /////////////

            // handle minus percent of another gifts
            // Get highest percent in gift table
            // Count number of item in table 
            $numberOfGiftItem = Gift::count();
            for($i = 0; $i < $numberOfGiftItem; $i++){
                $indexOfHighest = $i + 1;
                $valueTempHighest = Gift::where('id', $indexOfHighest)->value('current_percent');
                if($valueTempHighest > $highestPercent){
                    $highestPercent = $valueTempHighest;
                }
            }
            // Get min 
            for($y = 0; $y < $numberOfGiftItem ; $y++){
                $indexOfLowest = $y + 1 ;
                $valueTempLowest = Gift::where('id', $indexOfLowest)->value('current_percent');
                if($valueTempLowest < $lowestPercent){
                    $lowestPercent = $valueTempLowest;
                }
            }
            // Calculator average of max and min percent
            $average = ($highestPercent + $lowestPercent) / 2;
    
            // Get all gift have percent highest average 
    
            $giftsHaveBeenSelectedArray = Gift::where('current_percent' , '>', 'average')->get();
            // Handle minus percent all
            
            $itemOfGiftSelected = $giftsHaveBeenSelectedArray->count();

            // Calculator percent will be minus 
            $percentWillBeMinus = (10 / $itemOfGiftSelected) ? (10 / $itemOfGiftSelected) : false;

            for($z = 0 ; $z < $itemOfGiftSelected ; $z++){
                // get id of this gift
                $idOfThisGift = $giftsHaveBeenSelectedArray[$z]->value('id') ? $giftsHaveBeenSelectedArray[$z]->value('id') : false;
                $percentOfThisGift = $giftsHaveBeenSelectedArray[$z]->value('current_percent') ? $giftsHaveBeenSelectedArray[$z]->value('current_percent') : false;
                // Update new percent 
                Gift::where('id','=',$idOfThisGift)->limit(1)->update([
                    'current_percent' => $percentOfThisGift - $percentWillBeMinus
                ]);
                // Add item to test CAN DELETE AFTER DONE
            }
            
        }
        // Minus current amount of this gift

        $m_current_amount -= 1;
        
        // Update current percent and current amount of this gift
        Gift::where('id' , $randomNumber)->limit(1)->update([
                'current_percent' => $current_percent,
                'current_amount' => $m_current_amount
        ]);

        return response()->json([
            'type' => 'GIFT',
            'status' => 'SUCCESS',
            'message' => 'Get gift!',
            'current_percent' => $current_percent,
            'current_amount' => $m_current_amount,
            'gift' => (int)$randomNumber,
            '$_20percent' => $_20percent,
            '$_40percent' => $_40percent,
            '$_60percent' => $_60percent,
            '$_80percent' => $_80percent,
            'result_minus' => $result_minus,
            'percentWillBeMinus' => $percentWillBeMinus,
            'itemOfGiftSelected' => $itemOfGiftSelected,
            'Gift chosen' => $giftsHaveBeenSelectedArray
        ],201);

       
    }

    function testRandom($data, $result){
        for ($i = 0; $i < 1000000; $i++) {
            $randomElements = $this->random($data, $result);
            $randomElement = $randomElements[0];
            $results[$randomElement] = isset($results[$randomElement]) ? $results[$randomElement] + 1 : 1;
        }
        
        foreach ($results as $key => $value) {
            echo $key . ' :' . $value . ' times (' . $value / 1000000 * 100 . "%)\n";
        }
    }

    function random($data, $result){
        for ($i = 0; $i < 1; $i++) {
            if (!$data) {
                break;
            }
            $name = $this->getRandom($data);
            $result[] = $name;
            unset($data[$name]);
        }
        return $result;
    }

    private function getRandom($data){
        $total = 0;
        $distribution = [];
        foreach ($data as $name => $weight) {
            $total += $weight;
            $distribution[$name] = $total;
        }
        $rand = mt_rand(0, $total - 1);
        foreach ($distribution as $name => $weight) {
            if ($rand < $weight) {
                return $name;
            }
        }

    }
    public function luckypersonal(Request $request){
         // Check token
         $con = new MyConstant();

         if($con->tokenVail($request)){
             return response()->json([
                 'status' => 'ERROR',
                 'message' => 'Token expired !'
             ],400);
         }

        $array = array(
            [
                [
                    'name' => 'Nguyen Van Mot',
                    'image' => 'https://www.google.com.vn/url?sa=i&source=images&cd=&cad=rja&uact=8&ved=2ahUKEwjez6_eoJDgAhXi-GEKHd3yBa0QjRx6BAgBEAU&url=https%3A%2F%2Fwww.123rf.com%2Fphoto_1491871_iameg-of-a-yellow-wool-with-kniting-needles.html&psig=AOvVaw0YvSvFq6INCZplbwewGF8q&ust=1548757178390150',
                    'address' => 'HCM'
                ],
                [
                    'name' => 'Nguyen Van Mot',
                    'image' => 'https://www.google.com.vn/url?sa=i&source=images&cd=&cad=rja&uact=8&ved=2ahUKEwjez6_eoJDgAhXi-GEKHd3yBa0QjRx6BAgBEAU&url=https%3A%2F%2Fwww.123rf.com%2Fphoto_1491871_iameg-of-a-yellow-wool-with-kniting-needles.html&psig=AOvVaw0YvSvFq6INCZplbwewGF8q&ust=1548757178390150',
                    'address' => 'HCM'
                ]
            ]);

        return response()->json([
            'type' => 'GIFT',
            'status' => 'SUCCESS',
            'message' => 'Get list most lucky!',
            'list' => $array
        ],201);
    }

}