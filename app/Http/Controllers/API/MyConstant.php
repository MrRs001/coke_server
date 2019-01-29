<?php
namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;
class MyConstant{
    public  $DOMAIN  = "http://192.168.1.34";
    public  $STORAGE_IMAGE_CONTRACT = '/images/contracts';
    public  $STORAGE_IMAGE_GIFT = '/images/gifts';


    public static function getHostDomain(Request $request){

        $LOCAL_HOST_IP  = "http://192.168.1.34";
        
        $host = $request->getHost();
        if($host == 'localhost'){
            return $LOCAL_HOST_IP;
        }
        return 'http://'.$host;
    }

    public static function tokenVail(Request $request){
            $user = new UserController();
            $expired = $user->get_expired_at($request);
            if(Carbon::parse($expired) < Carbon::now()){
                return true;
            }
            return false;
    }

    public static function checkTokenRight(Request $request){
        $getToken = $request->bearerToken();
        return $getToken;
    }
}
