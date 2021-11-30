<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Model\product_list;

class searchController extends Controller
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
    public function index(Request $req)
    {
      if(!isset($req->search) || $req->search == ""){
        $product = product_list::where([['product_name', null], ['status', 0]])->orderBy('id', 'desc')->paginate(12);
      }else{
        $product = product_list::where('status', 0)->whereRaw("product_name like '%".$req->search."%' or product_code like '%".$req->search."%'")->orderBy('id', 'desc')->paginate(12);
      }

      return view('search', ['product' => $product]);
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
        //
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
}
