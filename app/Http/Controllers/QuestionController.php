<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\question;
use App\Model\comment;

class questionController extends Controller
{
    public function __construct()
    {
      // $this->middleware();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $question = question::select(
                              'question.id', 'question.user', 'question.password', 'question.title', 'question.contents',
                              'question.view', 'question.created_at',
                              DB::raw('count(comment.id) as cnt'))
                          ->where('status', 0)
                          ->leftjoin('comment', 'comment.question_id', '=', 'question.id')
                          ->groupby('question.id')
                          ->orderBy('id', 'desc')
                          ->paginate(10);

      return view('question', ['question' => $question]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('question_write');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $insert = question::insertGetId([
        'user' => $request->writer,
        'phone' => $request->phone,
        'password' => ($request->password),
        'title' => $request->title,
        'contents' => $request->content
      ]);

      $request->session()->put('user', $insert);

      return redirect("/question/".$insert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
      $question = question::where([['id', $id], ['status', 0]])->first();

      if(!isset($question)) return abort(404);

      if(!auth()->user()){
        if($request->session()->has('user')){
          if($request->session()->get('user') != $id){
            return redirect("/password?id=".$id);
          }
        }else{
          return redirect("/password?id=".$id);
        }
      };

      if(isset($_COOKIE['view_cookie'])){
        if(strpos($_COOKIE['view_cookie'], "q-".$id) === false) {
          setcookie('view_cookie', $_COOKIE['view_cookie']."|q-".$id, time() + 86400 * 30, "/");

          $update = question::where('id', $id)->update([
            'view' =>  $question->view + 1
          ]);
        }
      }else{
        setcookie('view_cookie', "q-".$id, time() + 86400 * 30, "/");

        $update = question::where('id', $id)->update([
          'view' =>  $question->view + 1
        ]);
      }

      $question = question::where([['id', $id], ['status', 0]])->first();

      $comment = comment::where('question_id', $id)->orderBy('id', 'asc')->get();

      return view('question_detail', ['question' => $question, 'comment' => $comment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
      if($request->session()->has('user')){
        if($request->session()->get('user') != $id){
          return redirect("/question")->with('alert', "잘못된 접근입니다.");
        }
      }else{
        return redirect("/question")->with('alert', "잘못된 접근입니다.");
      }

      $question = question::where([['id', $id], ['status', 0]])->first();

      return view('question_edit', ['question' => $question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if($request->session()->has('user')){
        if($request->session()->get('user') != $id){
          return redirect("/question")->with('alert', "잘못된 접근입니다.");
        }
      }else{
        return redirect("/question")->with('alert', "잘못된 접근입니다.");
      }

      $update = question::where('id', $id)->update([
        'title' => $request->title,
        'contents' => $request->content
      ]);

      return redirect("/question/".$id)->with('alert', "정상적으로 수정되었습니다.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
      if($request->session()->has('user')){
        if($request->session()->get('user') != $id){
          return redirect("/question")->with('alert', "잘못된 접근입니다.");
        }
      }else{
        return redirect("/question")->with('alert', "잘못된 접근입니다.");
      }

      $update = question::where('id', $id)->update([
        'status' => 1
      ]);

      return redirect("/question")->with('alert', "정상적으로 삭제되었습니다.");
    }
}
