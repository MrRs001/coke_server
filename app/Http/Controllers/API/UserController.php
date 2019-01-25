<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller{
    /**
     * Create user
     *
     * @param  [string] user_id
     * @param  [string] password
     */

    public function signup(Request $request)
    {

        // Check user existed
        if ($u = User::where('user_id', '=', $request->user_id)->first())
        {
            return response()->json([
                'type' => 'SIGNUP',
                'status' => 'ERROR',
                'message' => 'User existed!'
            ], 400);
        } 

        $request->validate([
            'user_id' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = new User([
            'user_id' => $request->user_id,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'type' => 'SIGNUP',
            'status' => 'SUCCESS',
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] user_id
     * @param  [string] password
     */
    public function login(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = request(['user_id', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'type' => 'LOGIN',
            'status' => 'SUCCESS',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
     /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
 

     

}