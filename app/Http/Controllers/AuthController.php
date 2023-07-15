<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Session;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:'.$request->model.'s,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        $model = "App\\Models\\".ucfirst($request->model);
        $user = $model::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request) 
    {
        $credentials = $request->validate([
            'email' => 'required|email|string',
            'password' => [
                'required',
            ],
            'remember' => 'boolean'
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if ($credentials) 
        {
            if(!Auth::guard($request->model)->attempt($credentials, $remember))
            {
                return response([
                    'error' => 'Invalid email or password combination.'
                ], 422);
            }  

            if(Auth::guard($request->model)->check()){
                $user = Session::get('user_session');
                $token = $user->createToken('main')->plainTextToken;

                return response([
                    'user' => $user,
                    'token' => $token
                ]);
            }
        }

        //  if(!Auth::attempt($credentials, $remember)){
        //     return response([
        //         'status' => 'failed', 
        //         'error' => 'The provided credentials are not correct.' 
        //     ]);
        // }else{
        //     $user = Auth::user();
        //     $token = $user->createToken('main')->plainTextToken;

        //     return response([
        //         'status' => 'success',
        //         'user' => $user,
        //         'token' => $token
        //     ]);
        // }

        // if(!Auth::attempt($credentials, $remember)){
        //     return response([
        //         'error' => $credentials->errors()
        //     ], 422);
        // }
        // Auth::attempt($credentials, $remember);
        // $user = Auth::user();
        // $token = $user->createToken('main')->plainTextToken;

        // return response([
        //     'user' => $user,
        //     'token' => $token
        // ]);

        
    }

    public function logout(Request $request){
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        Auth::guard($request->model)->logout();

        return response([
            'success' => true,
            // 'message' =>  $user
        ]);
    }
}
    