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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $passwordReset = DB::table('password_resets')->where('token', $request->input('token'))->first();

        if (!$user = User::where('email', $passwordReset->email)->first()){
            // throw new NotFoundHttpException('User not found!');
            return response(["message"=>"Not Found"]);
        }
        
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response ([
            'message'=>"success"
        ]);
        
        }
    }

