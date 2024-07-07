<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password
            ]);

            $token = $user->createToken($request->email)->accessToken;

            DB::commit();
            $data = new UserResource($user);
            return $this->apiResponse($data, $token, 'User Register successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return response()->json(['message' => 'Something Error !'], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        // Check email exist
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken($request->email)->accessToken;
        $data = new UserResource($user);

        return $this->apiResponse($data, $token, 'User Login successfully', 200);
    }

    public function logout(Request $request)
    {
        if (Auth::user())
            $request->user()->token()->revoke();

        return response()->json([
            'status' => 'success',
            'message' => 'User is logged out successfully'
        ], 200);
    }
}
