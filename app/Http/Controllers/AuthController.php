<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;

        if(empty($email) OR empty($password)){
            return response()->json([
                'status' => 'error',
                'message' => 'You must fill all the field'
            ]);
        }

        $client = new \GuzzleHttp\Client();

        try {
            return $client->post(config('service.passport.login_endpoint'),[
                "form_params" => [
                    "client_secret" => config('service.passport.client_secret'),
                    "grant_type" => "password",
                    "client_id" => config('passport.passport.client_id'),
                    "username" => $request->email,
                    "password" => $request->password
                ]
            ]);
        }catch (BadResponseException $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function register(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        if(empty($name) OR empty($email) OR empty($password)){
            return response()->json([
                'status' => 'error',
                'message' => 'You must fill all the field'
            ]);
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return response()->json([
                'status' => 'error',
                'message' => 'You must enter a valid email'
            ]);
        }

        if (strlen($password) < 6) {
            return response()->json([
               'status' => 'error',
               'message' => 'Password should be at least 6 character'
            ]);
        }

        if (User::where('email','=', $email)->exist()) {
            return response()->json([
                'status' => 'error',
                'message' => 'User already exist'
            ]);
        }

        try{
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = app('hash')->make($password);

            if ($user-save()){
                return 'user created successfully';
            }
        }catch (\Exception $exception){
            return response()->json([
               'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
}
