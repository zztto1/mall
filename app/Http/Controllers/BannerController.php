<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\banner;

class BannerController extends Controller
{
     public function __construct()
     {
       $this->middleware('auth');
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $banner = banner::get();

      return view('banner', ['banner' => $banner]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      banner::whereNotIn('id', $request->image_id)->delete();

      foreach ($request->image_check as $key => $value) {
        if($value == "Y"){

            $file_path = storage_path('app/public/banner');

            $imgd = $request->file('image')[$key];
            $extension = $imgd->getClientOriginalExtension();
            $file_name = $this->uuidgen().".".$extension;
            $imgd->move($file_path, $file_name);
            $file_name = "/storage/banner/".$file_name;

            if($request->image_id[$key] == 0){
              $insert = banner::insert([
                'img_path' => $file_name
              ]);
            }else{
              $upd = banner::where('id', $request->image_id[$key])->update([
                'img_path' => $file_name
              ]);
            }
        }
      }

      return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    function uuidgen() {
       return sprintf('%08x-%04x-%04x-%04x-%04x%08x',
          mt_rand(0, 0xffffffff),
          mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
          mt_rand(0, 0xffff), mt_rand(0, 0xffffffff)
        );
    }
}
