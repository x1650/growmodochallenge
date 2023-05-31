<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\LoginModel;
use App\Models\User;

class LoginController extends Controller
{
    protected function login(Request $request)
    {
        $email_username = $request->input('email');
        $credentials = $request->only('email', 'password');

        $user = User::select('username','email', 'id', 'userlevel')
                ->where('username', $email_username)
                ->orWhere('email', $email_username)
                ->first();
                

        if ($user && $user->getAttributes() && Auth::attempt(['email' => $user->getAttributes()['email'], 'password' => $credentials['password']])) {
            $userAttributes = $user->getAttributes();
            $response = [
                "data" => [
                    "user_id" => $userAttributes['id'],
                    "username" => $userAttributes['username'],
                    "userlevel" => $userAttributes['userlevel'],
                    "email" => $userAttributes['email'],
                    "token" => $user->createToken(time())->plainTextToken
                ],
                "status" => "success",
                "message" => "Login successful",
                "http_code" => 200,
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                "data" => [],
                "status" => "error",
                "message" => "Login failed",
                "http_code" => 401,
            ];

            return response()->json($response, 401);
        }
    }

    protected function register(Request $request)
    {

        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $phone_number = $request->input('phone_number');

        $checkEmail = User::where('email', $email)->first();
        $checkUsername = User::where('username', $username)->first();

        if($checkEmail && $checkUsername){
            $response = [
                "data" => [],
                "status" => "error",
                "title" => "Registration Failed",
                "message" => "Email and Username already taken, please try again.",
                "http_code" => 422,
            ];
            return response()->json($response, 422);
        }elseif($checkEmail){
            $response = [
                "data" => [],
                "status" => "error",
                "title" => "Registration Failed",
                "message" => "Email is already taken, please try again.",
                "http_code" => 422,
            ];
            return response()->json($response, 422);
        }elseif($checkUsername){
            $response = [
                "data" => [],
                "status" => "error",
                "title" => "Registration Failed",
                "message" => "Username is already taken, please try again.",
                "http_code" => 422,
            ];
            return response()->json($response, 422);
        }

        $data = array (
            'email' => $email,
            'username' => $username,
            'phone_number' => $phone_number,
            'password' => Hash::make($request->input('password')),
            'created_at' => date('Y-m-d H:i:s', time())
        );

        $addUser = User::insert($data);
        
        if ($addUser) {
            $response = [
                "data" => [
                    "username" => $username,
                    "email" => $email,
                ],
                "status" => "success",
                "title" => "Registration successful",
                "message" => "Welcome $username ($email)! You may now login to your account using the registered email or username and password!",
                "http_code" => 200,
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                "data" => [],
                "status" => "error",
                "title" => "Registration Failed",
                "message" => "There was an error encountered registering your account. Please try again, if the issue persists, please contact support.",
                "http_code" => 500
            ];

            return response()->json($response, 401);
        }
    }

    public function test(){
        // return [
        //     "user" => auth()->user()
        // ];
    }
}
