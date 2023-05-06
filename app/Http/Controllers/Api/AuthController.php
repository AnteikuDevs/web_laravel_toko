<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password))
        {
            return response([
                'status' => false,
                'message' => "Email atau Password yang anda masukkan salah"
            ]);
        }

        if($user->status == '0')
        {
            return response([
                'status' => false,
                'message' => "Akun anda belum diverifikasi"
            ]);
        }
        
        if($user->status == '2')
        {
            return response([
                'status' => false,
                'message' => "Akun anda tidak dapat diverifikasi"
            ]);
        }
        
        if($user->status == '3')
        {
            return response([
                'status' => false,
                'message' => "Akun anda dibekukan"
            ]);
        }

        $token = $user->createToken($user->name,['server:update'])->plainTextToken;

        User::find($user->id)->update(['remember_token' => $token]);

        return response([
            'status' => true,
            'message' => "Berhasil login",
            'token' => $token,
        ]);
    }
}
