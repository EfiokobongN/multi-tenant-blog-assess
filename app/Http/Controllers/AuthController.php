<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAccountRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Create User Account

    public function store(RegisterAccountRequest $request){
        DB::beginTransaction();
        try {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        DB::commit();
        Auth::login($user);

        $tokenResult = $user->createToken('token_name');
        $token = $tokenResult->plainTextToken;
        $expiration = Carbon::now()->addHour(8);
        $tokenResult->accessToken->expires_at = $expiration;
        $tokenResult->accessToken->save();

            return response()->json(['sucess'=> true, 'message' => 'Account Pending Approval', 'user'=> $user, 'token' => $token,], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['sucess' => false, 'message' => $th->getMessage()]);
        }
        
    }

    public function login(Request $request){
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $validate['email'];
        $password = $validate['password'];

        $user = User::where('email', $email)->first();

        if(!$user){
            return response()->json(['sucess' => false, 'message' => 'Email Address Not Found']);
        }

        if(!Hash::check($password, $user->password)){
            return response()->json(['sucess' => false, 'message' => 'InCorrect Password.']);
        }

        if (!$user->is_approved) {
            return response()->json(['message' => 'Account Not Approved.']);
        }

        $tokenResult = $user->createToken('token_name');
        $token = $tokenResult->plainTextToken;
        $expiration = Carbon::now()->addHour(8);
        $tokenResult->accessToken->expires_at = $expiration;
        $tokenResult->accessToken->save();

        return response()->json(['sucess'=> true, 'message' => 'Account Login Successful', 'token' => $token,], 200);
    }
}


