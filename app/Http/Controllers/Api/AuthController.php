<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UUIDGenerate;
use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'unique:users', 'min:9', 'max:11'],
                'password' => ['required', 'string', 'min:8', 'max:12'],
            ]
        );

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->ip = $request->ip();
        $user->user_agent = $request->server('HTTP_USER_AGENT');
        $user->login_at = date('Y-m-d H:i:s');
        $user->save();

        Wallet::firstOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'account_number' => UUIDGenerate::accountNumber(),
                'amount' => 0,
            ]
        );

        $token = $user->createToken('Unipay')->accessToken;

        return success('Successfully register.', ['token' => $token]);
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'phone' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]
        );

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = auth()->user();

            $user->ip = $request->ip();
            $user->user_agent = $request->server('HTTP_USER_AGENT');
            $user->login_at = date('Y-m-d H:i:s');
            $user->update();

            Wallet::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'account_number' => UUIDGenerate::accountNumber(),
                    'amount' => 0,
                ]
            );

            $token = $user->createToken('Unipay')->accessToken;
            return success('Successfully login.', ['token' => $token]);
        }

        return fail('These credentials do not match our records.', null);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->token()->revoke();

        return success('Successfully logout.', null);
    }
}
