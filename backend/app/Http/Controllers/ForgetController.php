<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\ForgetMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ForgetRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetController extends Controller
{
    public function ForgetPassword(Request $request)
    {
        $email = $request->input('email');
        $token = Str::random(12);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token
        ]);

        Mail::send('reset', ['token' => $token], function (Message $message) use ($email) {

            $message->subject('Reset your password');
            $message->to($email);

            return response([
                'message' => 'Check your Email'
            ]);
        });
    }
    public function ResetPassword(Request $request)
    {
        $request->validate([
            "token" => "required",
            "email" => "required|email",
            "password" => "required|min:8|confirmed",
        ]);

        $email = $request->input("email");
        $token = $request->input("token");
        $password = Hash::make($request->input("password"));
        $email_check = DB::table("password_resets")
            ->where("email", $email)
            ->first();
        $pin_check = DB::table("password_resets")
            ->where("token", $token)
            ->first();

        if (!$email_check) {
            return response()->json(
                [
                    "message" => "Email Not Found",
                ],
                401
            );
        }
        if (!$pin_check) {
            return response()->json(
                [
                    "message" => "Pin Code Invalid",
                ],
                401
            );
        }
        DB::table("users")
            ->where("email", $email)
            ->update(["password" => $password]);
        DB::table("password_resets")
            ->where("email", $email)
            ->delete();
        return response()->json([
            "message" => "Password Changed Successfully",
        ]);
    }
}
