<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;

class AuthResetPasswordPasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    //
    public function showResetForm($token)
    {
        return view('passwords.reset', compact('token'));
    }

    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'token' => ['required'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $passwordReset = PasswordReset::where('token', $request->token)->where('email', $request->email)->first();
        if (!empty($passwordReset)) {
            $user = User::where('email', $request->email)->first();
            if (!empty($user)) {
                $user->update([
                    'password' => bcrypt($request->password)
                ]);
                $passwordReset->delete();
                session()->flash('success', '密码已重置');
                return redirect('/');
            } else {
                session()->flash('warning', '用户不存在');
            }
        } else {
            session()->flash('warning', "验证信息失败");
        }
        return back();
    }
}
