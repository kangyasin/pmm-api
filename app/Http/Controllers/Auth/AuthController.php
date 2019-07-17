<?php

namespace App\Http\Controllers\Auth;

use App\ConfigDepositMembers;
use App\Deposit;
use App\DepositTransactionDetail;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\LoadController;
use App\Member;
use App\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\DepositTransaction;
use App\TsLoans;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => trans('auth.failed')], 401);
        }

        $response = $this->me();
        $response['error'] = null;
        return $response;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return auth()->user();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


}
