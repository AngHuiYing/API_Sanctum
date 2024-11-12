<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Validator;
//use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function register(Request $request) :JsonResponse{
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->sendError(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password']= Hash::make($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request) :JsonResponse {
        if(Auth::attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully');
        }

        return $this->sendError('Unauthorised.', ['error' => 'Unauthorised', 401]);
    }

    public function logout(Request $request)
    {
        // 删除当前用户的 Token
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
