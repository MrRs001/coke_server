<?php
namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;
class MyConstant{

    public  $DOMAIN  = "http://192.168.1.70";
    public  $STORAGE_IMAGE_CONTRACT = '/images/contracts';
    public  $STORAGE_IMAGE_GIFT = '/images/gifts';

   public function tokenVail(Request $request){
        $user = new UserController();
        $expired = $user->get_expired_at($request);
        if(Carbon::parse($expired) < Carbon::now()){
            return true;
        }
        return false;
   }

}
