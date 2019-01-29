<?php
namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;
class MyConstant{
    public  $LOCAL_HOST_IP  = "http://192.168.1.34";
    public  $DOMAIN  = "http://192.168.1.34";
    public  $STORAGE_IMAGE_CONTRACT = '/images/contracts';
    public  $STORAGE_IMAGE_GIFT = '/images/gifts';


    public function getHostDomain(Request $request){
        $host = $request->getHost();
        if($host == 'localhost'){
            return $this->LOCAL_HOST_IP;
        }
        return 'http://'.$host;
    }

    public function tokenVail(Request $request){
            $user = new UserController();
            $expired = $user->get_expired_at($request);
            if(Carbon::parse($expired) < Carbon::now()){
                return true;
            }
            return false;
    }
}
