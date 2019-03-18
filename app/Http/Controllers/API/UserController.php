<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Register new user with user and password decoded
     *
     * @param  [string] username
     * @param  [string] password
     */
    public function register(Request $request)
    {
        //Check username existed or not
        if ($u = User::where('username', '=', $request->username)->first()) {
            return response()->json([
                'type' => 'REGISTER',
                'status' => 'ERROR',
                'message' => 'User existed!',
            ], 400);
        }

        // Validate information
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            // Cash to User object
            $user = new User([
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ]);
            // Save user to database
            $user->save();

        } catch (\Exception $e) {
            // Return error to user
            return response()->json([
                'type' => 'REGISTER',
                'status' => 'ERROR',
                'message' => $e,
            ], 400);
        }

        // Return result to user
        return response()->json([
            'type' => 'REGISTER',
            'status' => 'SUCCESS',
            'message' => 'Successfully register new user!',
        ], 200);
    }

    /**
     * Login user and create token
     *
     * @param  [string] username
     * @param  [string] password
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

        $credentials = request(['username', 'password']);

        // Check user exited or not
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'type' => 'LOGIN',
                'status' => 'ERROR',
                'message' => 'Unauthorized',
            ], 401);
        }
            $user = $request->user();
            // Generate token for user
            $tokenResult = $user->createToken('Personal Access Token');
            // Get token from result
            $token = $tokenResult->token;
            // limit time life of token
            $token->expires_at = Carbon::now()->addWeeks(1);
            // Save token to handle
            $token->save();

            return response()->json([
                'type' => 'LOGIN',
                'status' => 'SUCCESS',
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                    'type' => 'LOGIN',
                    'status' => 'ERROR',
                    'message' => $e->getMessage(),
                ], 400
            );
        }
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
            'message' => 'Successfully logged out',
        ]);
    }

    public function get_expired_at(Request $request)
    {
        $expired_at = $request->user()->value('expired_at');
        return $expired_at;
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return $request->user();
    }

}
