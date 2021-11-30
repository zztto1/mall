<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\question;

class PasswordCheckController extends Controller
{
   public function index()
   {
      return view("question_password");
   }

    public function check(Request $req)
    {
      $question = question::where([['id', $req->id], ['password', ($req->password)]])->first();

      if(!isset($question->id)){
        return back()->with('alert', '비밀번호가 틀립니다. 비밀번호를 확인해주세요.');
      }

      $req->session()->put('user', $req->id);

      return redirect("/question/".$req->id);
    }
}
