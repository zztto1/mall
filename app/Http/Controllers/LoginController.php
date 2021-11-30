<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    /**
     * [로그인 및 로그아웃 API]
     * @author mhCho
     * @date   2020-10-01
     */

   public function index()
   {
      return view('login');
   }

    public function login(Request $request)
    {
        $id = $request->id;
        $pw = $request->pw;

        if(\Auth::attempt(['email' => $id, 'password' => $pw])){
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
