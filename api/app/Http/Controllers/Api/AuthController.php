<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use App\Models\User;
use App\Http\Resources\Models\User as UserResource;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if($validator->fails()) {
            return $this->sendError($validator->errors()->all(), 422);
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->save();

        return $this->sendResponse([], 'Successfully created user!', 200);
    }


    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user) {
            if(Hash::check($request->password, $user->password)) {

                $token = $user->createToken('Laravel User Client')->accessToken;

                return response()->json([
                    'user' => new UserResource($user),
                    'auth_token' => $token,
                    'message' => 'Session started'
                ], 200);

            } else {
                return $this->sendError('Password or Email missmatch', 422);
            }

        } else {
            return $this->sendError('The user doesnt exist', 422); 
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendResponse([], 'Successfully logged out', 200);
    }

    public function checkAuth(Request $request) 
    {
        $user = $request->user();
        UserResource::withoutWrapping();
        return new UserResource($user);
    }

}
