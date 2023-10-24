<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RsetPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:guest', ['except' => ['sendResetLinkEmail', 'reset', 'validReset']]);
    }

    public function validReset(Request $request, $token)
    {
        $email = $request->query('email');

        $user = User::where('email', $email);
        if ($user) {
            $reset = ResetPassword::where('token', $token);

            if ($user->email == $reset->email) {
                return response()->json([
                    'message' => 'Validation succes',
                    'email' => $email,
                    'token' => $token,
                ], 201);
            }

            return response()->json(['message' => 'Validation failed'], 422);
        }

        return response()->json(['message' => 'User Not Found'], 422);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed'], 422);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent to your email'], 201);
        }

        return response()->json(['message' => 'Unable to send password reset link'], 401);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed'], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password successfully reset'], 201);
        }

        return response()->json(['message' => 'Unable to reset password'], 401);
    }
}