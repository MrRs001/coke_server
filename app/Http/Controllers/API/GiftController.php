<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftController extends Controller{

    public function requestgift(Request $request){
        // random_gift();
        return 'Request';
    }

    public function random_gift(){
     
        $number = array(1 => 0.1, 2 => 0.1, 3 => 0.1, 4 => 0.2, 5 => 0.2, 5 => 0.3 );

        $rand = (float)rand()/(float)getrandmax();

        foreach ($number as $value => $weight) {
           if ($rand < $weight) {
              $result = $value;
              break;
           }
           $rand -= $number;
        }

        echo $rand;
        
    }

}