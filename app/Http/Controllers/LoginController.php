<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserInfo;
use App\Models\UserDoc;

class LoginController extends Controller
{
    /**
     * Initialize the login action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        if (! $token = Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'msg' => 'Wrong credentials.',
            ]);
        }
        $userdocdatas=UserDoc::get();
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => ['data'=>Auth::setToken($token)->user(),'info'=>UserInfo::where('user_id', Auth::setToken($token)->user()->id)->first(),'docs'=>$userdocdatas],
          
        ]);
    }
}
