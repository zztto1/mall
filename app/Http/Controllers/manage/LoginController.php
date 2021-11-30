<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class LoginController extends Controller
{

    /**
     * [로그인 및 로그아웃 API]
     * @author mhCho
     * @date   2020-10-01
     */

    public function login(Request $request)
    {
        $id = $request->id;
        $pw = $request->pw;
        $remember = $request->remember;

        if(\Auth::attempt(['email' => $id, 'password' => $pw], $remember)){
          return response()->json([
              'result' => 200
            ]);
        }

        return response()->json([
            'result' => 500
          ]);
    }

    public function logout()
    {
        \Auth::logout();
        return redirect('/login');
    }
}
