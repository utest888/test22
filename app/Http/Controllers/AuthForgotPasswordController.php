<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    //
    public function showLinkRequestForm()
    {

        return view('passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            $passwordReset = PasswordReset::create([
                'email' => $request->email
            ]);
            $this->sendEmailResetPasswordTo($passwordReset->token, $user);
            session()->flash('success', "重置邮件已发送");
        } else {
            session()->flash('warning', '用户邮箱不存在');
        }

        return back();
    }

    protected function sendEmailResetPasswordTo($token, $user)
    {
        $view = 'emails.reset';
        $data = compact('token');
        $to = $user->email;
        $subject = '您正在找回密码，请确认您的邮箱';

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }
}
