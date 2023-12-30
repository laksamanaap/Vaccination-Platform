<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function loginUsers(Request $request) 
    {

        $validator = Validator::make($request->all(), [
            'id_card_number' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

       $user = User::where('id_card_number', $request->input('id_card_number'))->first();

       if ($user && $request->input('password') === $user->password) {
            Auth::login($user);

            $token = md5($request->input("id_card_number"));
            $user->update(['login_tokens' => $token]);

            $regional = $user->regionals;

            return response()->json($user,200);
        } else {
            return response()->json(['error' => 'Try to check your id_card_number or password'],404);
        }
    }


    public function logoutUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Token is required'], 400);
        }

        $inputToken = $request->input('token');

        $user = User::where('login_tokens', $request->input('token'))
        ->update(["login_tokens" => null]);

        if ($user > 0) {
            return response()->json(['message' => 'Logout success'], 200);
        } else {
            return response()->json(['message' => 'Invalid token'], 500);
        }



    }
}
