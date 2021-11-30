<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\notice;

class noticeController extends Controller
{

     public function __construct()
     {
       $this->middleware('auth')->except(['index', 'show']);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $notice = notice::where('status', 0)->orderBy('id', 'desc')->paginate(10);

      return view('notice', ['notice' => $notice]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('notice_write');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $insert = notice::insertGetId([
        'title' => $request->title,
        'contents' => $request->content
      ]);

      return redirect("/notice/".$insert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $notice = notice::where([['id', $id], ['status', 0]])->first();

      if(!isset($notice)) return abort(404);

      if(isset($_COOKIE['view_cookie'])){
        if(strpos($_COOKIE['view_cookie'], "n-".$id) === false) {
          setcookie('view_cookie', $_COOKIE['view_cookie']."|n-".$id, time() + 86400 * 30, "/");

          $update = notice::where('id', $id)->update([
            'view' =>  $notice->view + 1
          ]);
        }
      }else{
        setcookie('view_cookie', "n-".$id, time() + 86400 * 30, "/");

        $update = notice::where('id', $id)->update([
          'view' =>  $notice->view + 1
        ]);
      }

      $notice = notice::where([['id', $id], ['status', 0]])->first();

      return view('notice_detail', ['notice' => $notice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $notice = notice::where([['id', $id], ['status', 0]])->first();

      return view('notice_edit', ['notice' => $notice]);
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
      $update = notice::where('id', $id)->update([
        'title' => $request->title,
        'contents' => $request->content
      ]);

      return redirect("/notice/".$id)->with('alert', "정상적으로 수정되었습니다.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $update = notice::where('id', $id)->update([
        'status' => 1
      ]);

      return redirect("/notice")->with('alert', "정상적으로 삭제되었습니다.");
    }
}
