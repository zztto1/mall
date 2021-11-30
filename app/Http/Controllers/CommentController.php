<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\question;
use App\Model\comment;

class CommentController extends Controller
{

  // 댓글 작성
  public function create(Request $req)
   {
      if (!isset(auth()->user()->id)){
        if($req->session()->has('user')){
          if($req->session()->get('user') != $req->question_id){
            return redirect("/question")->with('alert', "잘못된 접근입니다.");
          }
        }else{
          return redirect("/question")->with('alert', "잘못된 접근입니다.");
        }
      }

      $question = question::where('id', $req->question_id)->first();

      if(!isset($question->id)) {
        return redirect("/question")->with('alert', "잘못된 접근입니다.");
      }

      if (isset(auth()->user()->id)){
        $user = "관리자";
      }else{
        $question = question::where('id', $req->question_id)->first();

        $user = $question->user;
      }

      $insert = comment::insert([
        'question_id' =>  $req->question_id,
        'user' =>  $user,
        'contents' =>  $req->comment,
      ]);

      return redirect("/question/".$req->question_id)->with('alert', "댓글이 등록되었습니다");
    }


    // 댓글 삭제
    public function delete(Request $req)
    {
      if (!isset(auth()->user()->id)){
        if($req->session()->has('user')){
          if($req->session()->get('user') != $req->question_id){
            return redirect("/question")->with('alert', "잘못된 접근입니다.");
          }
        }else{
          return redirect("/question")->with('alert', "잘못된 접근입니다.");
        }
      }

      $question = question::where('id', $req->question_id)->first();

      if(!isset($question->id)) {
        return redirect("/question")->with('alert', "잘못된 접근입니다.");
      }

      comment::where('id', $req->comment_id)->delete();

      return redirect("/question/".$req->question_id)->with('alert', "댓글이 삭제되었습니다");
    }
}
